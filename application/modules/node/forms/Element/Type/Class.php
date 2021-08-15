<?php

class Node_Form_Element_Type_Class extends Zend_Form_Element_Text
{
    // Maximum length of title.
    const MAX_LENGTH = 80;
    
    public function init()
    {
        $this->setLabel('Class')
             ->setDescription('The PHP class name of the objects this node type represents.')
             ->setRequired(TRUE)
             ->setOrder(3)
             ->addFilters(array('StripTags', 'StringTrim'))
             ->addValidator('StringLength', false, array(NULL, self::MAX_LENGTH))
             ->setAttrib('maxlength', self::MAX_LENGTH);
    }
}