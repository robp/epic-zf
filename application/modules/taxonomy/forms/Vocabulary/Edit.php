<?php

class Taxonomy_Form_Vocabulary_Edit extends EPIC_Form
{

    public function init()
    {
        $this->addElement('text', 'name', array(
            'label' => 'Name',
            'description' => 'The name for this vocabulary, e.g., "Tags".',
            'required' => TRUE,
            'order' => 20,
            'filters' => array('StripTags', 'StringTrim'))
        );

        $description = new EPIC_Form_Element_ResizeableTextarea('description');
        $description->setLabel('Description')
                    ->setDescription('Description of the vocabulary; can be used by modules.')
                    ->setOrder(40)
                    ->setFilters(array('StripTags', 'StringTrim'));
        $this->addElement($description);

        $this->addElement('text', 'help', array(
            'label' => 'Help Text',
            'description' => 'Instructions to present to the user when selecting terms, e.g., "Enter a comma separated list of words".',
            'order' => 60,
            'filters' => array('StripTags', 'StringTrim'))
        );

        $nodetypes = Doctrine_Core::getTable('Node_Model_Type')->findAll();
        
        $typeElements = array();
        $typeElementNames = array();
        
        $nodetypesSubForm = new EPIC_Form_SubForm();
        $nodetypesSubForm->setLegend('Node Types')
                         ->setDescription('Select content types to categorize using this vocabulary.');
        
        foreach ($nodetypes as $nodetype) {
            $element = new EPIC_Form_Element_CheckboxOption($nodetype->name);
            $element->setLabel($nodetype->title);
            $nodetypesSubForm->addElement($element);
        }

        $this->addSubForm($nodetypesSubForm, 'nodetypes', 80);
        
        $tags = new EPIC_Form_Element_CheckboxOption('tags');
        $tags->setLabel('Tags')
             ->setDescription('Terms are created by users when submitting posts by typing a comma separated list.');
        $this->addElement($tags);

        $multiple = new EPIC_Form_Element_CheckboxOption('multiple');
        $multiple->setLabel('Multiple select')
                 ->setDescription('Allows posts to have more than one term from this vocabulary (always true for tags).');
        $this->addElement($multiple);

        $required = new EPIC_Form_Element_CheckboxOption('required');
        $required->setLabel('Required')
                 ->setDescription('At least one term in this vocabulary must be selected when submitting a post.');
        $this->addElement($required);
        
        $this->addElement('text', 'weight', array(
            'label' => 'Weight',
            'description' => 'Vocabularies are displayed in ascending order by weight.',
            'required' => TRUE,
            'filters' => array('Int'))
        );
        
        $this->addDisplayGroup(array('tags', 'multiple', 'required', 'weight'), 'settings', array(
        	'order' => 900
        ));
        $this->getDisplayGroup('settings')->setLegend('Settings');
        
        $this->getDisplayGroup('buttons')->addElement(
            new Zend_Form_Element_Submit('delete', array(
            'label' => 'Delete...',
            'order' => 200
        )));
        
        $this->getElement('submit')->setLabel('Save');
    }
    
    public function setDefaults(array $defaults)
    {
        parent::setDefaults($defaults);
        
        $vocabulary = Doctrine_Core::getTable('Taxonomy_Model_Vocabulary')->find($defaults['id']);

        foreach ($vocabulary->Types as $nodetype) {
            $this->getSubForm('nodetypes')->getElement($nodetype->name)->setChecked(TRUE);
        }
    }
}
