<?php

class Contact_Form_Contact extends EPIC_Form
{
    
    public function init()
    {
        $this->addElement('text', 'name', array(
            'label' => 'Name',
            'required' => TRUE,
            'maxlength' => 100,
            'filters' => array('StripTags', 'StringTrim'),
            'validators' => array(
                array('StringLength', false, array(NULL, 100))
            )
        ));
        
        $this->addElement('text', 'email', array(
            'label' => 'Email',
            'required' => TRUE,
            'maxlength' => 100,
            'filters' => array('StripTags', 'StringTrim'),
            'validators' => array(
                'EmailAddress',
                array('StringLength', false, array(NULL, 100))
            )
        ));
        
        $this->addElement('text', 'url', array(
            'label' => 'URL',
            'maxlength' => 255,
            'filters' => array('StripTags', 'StringTrim'),
            'validators' => array(
                array('Regex', false, array('/^http:\/\/(.+)?\.(.{2,})$/')),
                array('StringLength', false, array(NULL, 255))
            )
        ));
        
        $this->addElement('textarea', 'comment', array(
            'label' => 'Your message',
            'required' => TRUE,
            'rows' => 4,
            'class' => 'resizable',
            'filters' => array('StripTags', 'StringTrim'),
            'validators' => array(
                array('StringLength', false, array(NULL, 1000))
            )
        ));
        
        $this->addSubForm(new Captcha_Form_SubForm_Captcha(), 'captcha');
        
        $this->getElement('submit')->setLabel('Send Message');
    }

    public function process()
    {
    }
}