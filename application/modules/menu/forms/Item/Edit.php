<?php

class Menu_Form_Item_Edit extends EPIC_Form
{

    public function init()
    {
        $this->addElement('text', 'module', array(
            'label' => 'Module',
            'order' => 10,
            'maxlength' => 40,
            'filters' => array('StripTags', 'StringTrim', 'Word_UnderscoreToDash', 
            	array('Word_SeparatorToDash', ' '))
        ));

        $this->addElement('text', 'controller', array(
            'label' => 'Controller',
            'order' => 20,
            'maxlength' => 40,
            'filters' => array('StripTags', 'StringTrim', 'Word_UnderscoreToDash', 
            	array('Word_SeparatorToDash', ' '))
        ));
        
        $this->addElement('text', 'action', array(
            'label' => 'Action',
            'order' => 30,
            'maxlength' => 40,
            'filters' => array('StripTags', 'StringTrim', 'Word_UnderscoreToDash', 
            	array('Word_SeparatorToDash', ' '))
        ));
        
        $this->addElement('text', 'route', array(
            'label' => 'Route',
            'order' => 40,
            'maxlength' => 40,
            'filters' => array('StripTags', 'StringTrim')
        ));

        $reset = new EPIC_Form_Element_CheckboxOption('reset_params');
        $reset->setLabel('Reset Parameters')
                 ->setDescription('Reset URL parameters when generating this link.')
                 ->setOrder(45);
        $this->addElement($reset);
        
        $this->addElement('text', 'resource', array(
            'label' => 'Resource',
            'order' => 50,
            'maxlength' => 40,
            'filters' => array('StripTags', 'StringTrim')
        ));
        
        $this->addElement('text', 'privilege', array(
            'label' => 'Privilege',
            'order' => 60,
            'maxlength' => 40,
            'filters' => array('StripTags', 'StringTrim')
        ));

        $label = new Menu_Form_Item_Element_Label('label');
        $label->setRequired(TRUE)
              ->setOrder(90);
        $this->addElement($label);
        
        $description = new EPIC_Form_Element_ResizeableTextarea('description');
        $description->setLabel('Description')
                    ->setDescription('Description of the menu.')
                    ->setOrder(100)
                    ->setFilters(array('StripTags', 'StringTrim'));
        $this->addElement($description);
        
        $visible = new EPIC_Form_Element_CheckboxOption('visible');
        $visible->setLabel('Visible')
                ->setDescription('Menu items that are not visible will not be listed in any menu.')
                ->setOrder(120);
        $this->addElement($visible);
        
        $expanded = new EPIC_Form_Element_CheckboxOption('expanded');
        $expanded->setLabel('Expanded')
                 ->setDescription('If selected and this menu item has children, the menu will always appear expanded.')
                 ->setOrder(140);
        $this->addElement($expanded);
        
        $order = new Menu_Form_Item_Element_Order('order');
        $order->setRequired(TRUE)
              ->setOrder(160);
        $this->addElement($order);
        
        $this->getDisplayGroup('buttons')->addElement(
            new Zend_Form_Element_Submit('delete', array(
            'label' => 'Delete...',
            'order' => 200
        )));
        
        $this->getElement('submit')->setLabel('Save');
    }
}
