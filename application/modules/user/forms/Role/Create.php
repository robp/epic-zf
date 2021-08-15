<?php

class User_Form_Role_Create extends User_Form_Role_Edit
{
    
    public function init()
    {
        parent::init();
        $this->getDisplayGroup('buttons')->removeElement('delete');
    }
}
