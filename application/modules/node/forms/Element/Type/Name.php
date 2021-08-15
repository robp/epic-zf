<?php

class Node_Form_Element_Type_Name extends Zend_Form_Element_Text
{
    // Maximum length of title.
    const MAX_LENGTH = 40;
    
    public function init()
    {
        $this->setLabel('Name')
             ->setDescription('The machine-readable name of this content type. This text will be used for constructing the URL of the create content page for this content type. This name must contain only lowercase letters, numbers, and underscores. Underscores will be converted into hyphens when constructing the URL of the create content page. This name must be unique.')
             ->setRequired(TRUE)
             ->setOrder(2)
             ->addFilters(array('StripTags', 'StringTrim'))
             ->addValidator('StringLength', false, array(NULL, self::MAX_LENGTH))
             ->setAttrib('maxlength', self::MAX_LENGTH);
    }
}