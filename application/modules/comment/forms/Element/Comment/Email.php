<?php

class Comment_Form_Element_Comment_Email extends Zend_Form_Element_Text
{
    // Maximum length of title.
    const MAX_LENGTH = 255;
    
    public function init()
    {
        $this->setName('email')
             ->setLabel('Email Address')
             ->setDescription('Your email address will not be published.')
             ->setRequired(TRUE)
             ->setOrder(6)
             ->addFilters(array('StripTags', 'StringTrim'))
             ->addValidator('EmailAddress')
             ->setAttrib('maxlength', self::MAX_LENGTH);
    }
}