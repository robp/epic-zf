<?php

class User_Form_Create extends User_Form_Edit
{
    
    public function init()
    {
        parent::init();
        $this->getDisplayGroup('buttons')->removeElement('delete');
        $this->getElement('new_password')->setRequired(TRUE);
        $this->getElement('new_password_confirm')->setRequired(TRUE);
    }
}
