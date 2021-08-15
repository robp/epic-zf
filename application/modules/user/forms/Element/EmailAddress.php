<?php

class User_Form_Element_EmailAddress extends Zend_Form_Element_Text
{
    // Maximum length of email address.
    const MAX_LENGTH = 80;
    
    public function init()
    {
        $config = Zend_Registry::get('config');
        
        $maxLength = isset($config->modules->user->emailAddress->maxLength) ?
            $config->modules->user->emailAddress->maxLength : self::MAX_LENGTH;
            
        $this->setLabel('Email Address')
             ->setDescription('Enter a valid email address.')
             ->addFilters(array('StripTags', 'StringTrim'))
             ->addValidator('StringLength', false, array(NULL, $maxLength))
             ->addValidator('EmailAddress')
             ->setAttrib('maxlength', $maxLength);
    }
}