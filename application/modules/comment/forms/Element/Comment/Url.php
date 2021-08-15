<?php

class Comment_Form_Element_Comment_Url extends Zend_Form_Element_Text
{
    // Maximum length of title.
    const MAX_LENGTH = 255;
    
    public function init()
    {
        $this->setName('url')
             ->setLabel('URL')
//             ->setDescription('Your website address.')
             ->setOrder(9)
             ->addFilters(array('StripTags', 'StringTrim'))
             ->setAttrib('maxlength', self::MAX_LENGTH);
    }
}