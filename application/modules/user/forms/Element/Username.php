<?php

class User_Form_Element_Username extends Zend_Form_Element_Text
{
    // Minimum length of user-created usernames.
    const MIN_LENGTH = 2;
    
    // Maximum length of user-created usernames.
    const MAX_LENGTH = 20;
    
    public function init()
    {
        $config = Zend_Registry::get('config');
        
        $minLength = isset($config->modules->user->username->minLength) ?
            $config->modules->user->username->minLength : self::MIN_LENGTH;

        $maxLength = isset($config->modules->user->username->maxLength) ?
            $config->modules->user->username->maxLength : self::MAX_LENGTH;
            
        $this->setLabel('Username')
             ->setDescription('Choose a username between ' . $minLength . ' and ' . $maxLength . ' characters in length.')
             ->addFilters(array('StripTags', 'StringTrim'))
             ->addValidator('StringLength', false, array($minLength, $maxLength))
             ->setAttrib('maxlength', $maxLength);
    }
}