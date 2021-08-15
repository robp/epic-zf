<?php

class EPIC_Form_Element_CheckboxOption extends Zend_Form_Element_Checkbox
{
    
    public function init()
    {
        $this->clearDecorators()
             ->addDecorators(array('ViewHelper', 'Label', 'Errors', 'Description'))
             ->addDecorator('HtmlTag', array('tag' => 'dd', 'id' => $this->getName() . '-element'));
             
        $this->getDecorator('Label')->setOption('placement', Zend_Form_Decorator_Abstract::APPEND);
    }
}