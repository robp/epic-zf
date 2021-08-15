<?php

class EPIC_Form_Delete extends EPIC_Form
{
    
    public function init()
    {
        $cancel = new Zend_Form_Element_Submit('cancel', array(
            'label' => 'Cancel',
            'order' => 50
        ));
        
        $this->getDisplayGroup('buttons')->addElement($cancel);
        
        $this->getElement('submit')->setLabel('Delete');
    }
}
