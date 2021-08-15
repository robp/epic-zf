<?php

class User_Form_Element_Password extends Zend_Form_Element_Password
{
    // Minimum length of user-generated passwords.
    const MIN_LENGTH = 6;

    // Maximum length of user-generated passwords.
    const MAX_LENGTH = NULL;
    
    public function init()
    {
        $config = Zend_Registry::get('config');
        
        $minLength = isset($config->modules->user->password->minLength) ?
            $config->modules->user->password->minLength : self::MIN_LENGTH;

        $maxLength = isset($config->modules->user->password->maxLength) ?
            $config->modules->user->password->maxLength : self::MAX_LENGTH;
            
        $this->setLabel('Password')
             ->setDescription('Choose a password of at least ' . $minLength . ' characters.')
             ->addValidator('StringLength', false, array($minLength, $maxLength))
             ->setAttrib('maxlength', $maxLength);
    }
}