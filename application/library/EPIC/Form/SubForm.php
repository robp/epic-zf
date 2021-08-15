<?php

class EPIC_Form_SubForm extends Zend_Form_SubForm
{

    public function __construct($options = null)
    {
        parent::__construct($options);

        $class = 'epic-subform';
        
        // Don't add the collapsible class if collapsibleClosed already exists.
        if (!strstr($this->getAttrib('class'), 'collapsibleClosed')) {
            $class .= ' collapsible';
        }
        
        $this->setAttrib('class', trim("$class " . $this->getAttrib('class')));
        $this->clearDecorators()
             ->addDecorator('FormElements')
             ->addDecorator('HtmlTag', array('tag' => 'dl'))
             ->addDecorator('Description')
             ->addDecorator(new EPIC_Form_Decorator_CollapsibleFieldset())
             ->addDecorator('DtDdWrapper');

        EPIC_Form::setLabelOptions($this);
    }
    
    public function process(array $context = array())
    {
    }
}