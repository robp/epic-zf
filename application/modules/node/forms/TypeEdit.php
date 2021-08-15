<?php

class Node_Form_TypeEdit extends EPIC_Form
{

    public function init()
    {
        $this->addElement(new Node_Form_Element_Type_Title('title'));
//        $this->addElement(new Node_Form_Element_Type_Name('name'));
//        $this->getElement('name')->disable = TRUE;
        $this->addElement(new Node_Form_Element_Type_Class('class'));
        
        $this->addElement('text', 'description', array(
            'label' => 'Description',
            'maxlength' => 255,
            'order' => 10
        ));

        $hasTitle = new EPIC_Form_Element_CheckboxOption('hasTitle');
        $hasTitle->setLabel('Has Title');
        $this->addElement($hasTitle);

        $this->addElement('text', 'titleLabel', array(
            'label' => 'Title field label',
            'required' => TRUE
        ));

        $hasBody = new EPIC_Form_Element_CheckboxOption('hasBody');
        $hasBody->setLabel('Has Body');
        $this->addElement($hasBody);
        
        $this->addElement('text', 'bodyLabel', array(
            'label' => 'Body field label',
        	'description' => 'To omit the body field for this content type, remove any text and leave this field blank.'
        ));
        
        $this->addDisplayGroup(array('hasTitle', 'titleLabel', 'hasBody', 'bodyLabel'), 'submission-form-settings', array(
            'legend' => 'Submission form settings',
            'order' => 50,
        ));
        $this->getDisplayGroup('submission-form-settings')->setAttrib('class', 'collapsibleClosed');
        
        $this->getElement('submit')->setLabel('Save');
    }
}
