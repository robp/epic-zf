<?php

class Taxonomy_Form_Term_Edit extends EPIC_Form
{

    public function init()
    {
        $this->addElement('text', 'name', array(
            'label' => 'Name',
            'description' => 'The name of this term.',
            'required' => TRUE,
            'order' => 20,
            'filters' => array('StripTags', 'StringTrim'))
        );

        $description = new EPIC_Form_Element_ResizeableTextarea('description');
        $description->setLabel('Description')
                    ->setDescription('A description of the term. To be displayed on taxonomy/term pages and RSS feeds.')
                    ->setOrder(40)
                    ->setFilters(array('StripTags', 'StringTrim'));
        $this->addElement($description);

        $this->addElement('text', 'weight', array(
            'label' => 'Weight',
            'description' => 'Terms are displayed in ascending order by weight.',
            'required' => TRUE,
            'filters' => array('Int'))
        );
        
        $this->addDisplayGroup(array('weight'), 'advanced', array(
        	'order' => 900
        ));
        $this->getDisplayGroup('advanced')->setLegend('Advanced options')
                                          ->setAttrib('class', 'collapsibleClosed');
        
        $this->getDisplayGroup('buttons')->addElement(
            new Zend_Form_Element_Submit('delete', array(
            'label' => 'Delete...',
            'order' => 200
        )));
        
        $this->getElement('submit')->setLabel('Save');
    }
}
