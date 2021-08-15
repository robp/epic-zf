<?php

class Menu_Form_Menu_Edit extends EPIC_Form
{

    public function init()
    {
        $this->addElement('text', 'name', array(
            'label' => 'Name',
            'description' => 'The system name for this menu, e.g., "primary-links".',
            'required' => TRUE,
            'order' => 20,
            'maxlength' => 40,
            'filters' => array('StripTags', 'StringTrim', 'Word_UnderscoreToDash', 
            	array('Word_SeparatorToDash', ' '))
        ));

        $this->addElement('text', 'title', array(
            'label' => 'Title',
            'description' => 'The full name for this menu, e.g., "Primary Links".',
            'required' => TRUE,
            'order' => 40,
            'maxlength' => 80,
            'filters' => array('StripTags', 'StringTrim'))
        );
        
        $description = new EPIC_Form_Element_ResizeableTextarea('description');
        $description->setLabel('Description')
                    ->setDescription('Description of the menu.')
                    ->setOrder(60)
                    ->setFilters(array('StripTags', 'StringTrim'));
        $this->addElement($description);

        $this->getDisplayGroup('buttons')->addElement(
            new Zend_Form_Element_Submit('delete', array(
            'label' => 'Delete...',
            'order' => 200
        )));
        
        $this->getElement('submit')->setLabel('Save');
    }
}
