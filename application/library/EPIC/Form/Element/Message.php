<?php

class EPIC_Form_Element_Message extends Zend_Form_Element_Text
{
    
    public function init()
    {
        $this->clearDecorators()
             ->addDecorators(array('Label', 'Description'))
             ->addDecorator('HtmlTag', array('tag' => 'dd', 'id' => $this->getName() . '-element'));
             
        // This removes the ':' suffix from the label.
        $this->getDecorator('Label')->setOption('placement', Zend_Form_Decorator_Abstract::APPEND);
    }
}