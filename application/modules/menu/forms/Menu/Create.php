<?php

class Menu_Form_Menu_Create extends Menu_Form_Menu_Edit
{
    
    public function init()
    {
        parent::init();
        $this->getDisplayGroup('buttons')->removeElement('delete');
    }
}
