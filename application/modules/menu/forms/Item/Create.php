<?php

class Menu_Form_Item_Create extends Menu_Form_Item_Edit
{
    
    public function init()
    {
        parent::init();
        $this->getDisplayGroup('buttons')->removeElement('delete');
    }
}
