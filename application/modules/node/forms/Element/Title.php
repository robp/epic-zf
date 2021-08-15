<?php

class Node_Form_Element_Title extends Zend_Form_Element_Text
{
    // Maximum length of title.
    const MAX_LENGTH = 255;
    
    public function init()
    {
        $this->setLabel('Title')
             ->setRequired(TRUE)
             ->setOrder(10)
             ->addFilters(array('StripTags', 'StringTrim'))
             ->addValidator('StringLength', false, array(NULL, self::MAX_LENGTH))
             ->setAttrib('maxlength', self::MAX_LENGTH);
    }
}