<?php

class Node_Form_Element_Story_Dateline extends Zend_Form_Element_Text
{
    // Maximum length of field.
    const MAX_LENGTH = 255;
    
    public function init()
    {
        $this->setName('story_dateline')
             ->setLabel('Dateline')
             ->setDescription('The location where this story takes place.')
             ->setOrder(100)
             ->addFilters(array('StripTags', 'StringTrim'))
             ->addValidator('StringLength', false, array(NULL, self::MAX_LENGTH))
             ->setAttrib('maxlength', self::MAX_LENGTH);
    }
}