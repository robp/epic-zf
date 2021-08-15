<?php

class Comment_Form_Element_Comment_Name extends Zend_Form_Element_Text
{
    // Maximum length of title.
    const MAX_LENGTH = 80;
    
    public function init()
    {
        $this->setName('name')
             ->setLabel('Name')
//             ->setDescription('Your name.')
             ->setRequired(TRUE)
             ->setOrder(3)
             ->addFilters(array('StripTags', 'StringTrim'))
             ->setAttrib('maxlength', self::MAX_LENGTH);
    }
}