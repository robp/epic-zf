<?php

class Menu_Form_Item_Element_Label extends Zend_Form_Element_Text 
{
    const MAX_LENGTH = 40;

    public function init()
    {
        $this->setLabel('Label')
             ->setDescription('The link text corresponding to this item that should appear in the menu.')
             ->setAttrib('maxlength', self::MAX_LENGTH)
             ->setFilters(array('StripTags', 'StringTrim'));
    }
}
        