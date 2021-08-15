<?php

class Menu_Form_Node_Form_Create_SubForm extends Menu_Form_Node_Form_Edit_SubForm
{
    
    public function init()
    {
        parent::init();
        $this->removeElement('delete');
        $this->setAttrib('class', 'collapsibleClosed');
    }
}
