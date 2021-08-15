<?php

class Node_Form_Element_Type_Title extends Zend_Form_Element_Text
{
    // Maximum length of title.
    const MAX_LENGTH = 80;
    
    public function init()
    {
        $this->setLabel('Title')
             ->setDescription('The human-readable name of this content type. This text will be displayed as part of the list on the create content page. It is recommended that this name begin with a capital letter and contain only letters, numbers, and spaces. This name must be unique.')
             ->setRequired(TRUE)
             ->setOrder(1)
             ->addFilters(array('StripTags', 'StringTrim'))
             ->addValidator('StringLength', false, array(NULL, self::MAX_LENGTH))
             ->setAttrib('maxlength', self::MAX_LENGTH);
    }
}