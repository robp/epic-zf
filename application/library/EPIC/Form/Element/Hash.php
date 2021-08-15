<?php

class EPIC_Form_Element_Hash extends Zend_Form_Element_Hash 
{

    // Have to do this with __construct(). Using init()
    // seems to break the functionality.
    public function __construct($spec, $options = null)
    {
        parent::__construct($spec, $options);
        $this->setSalt(time())
             ->setDecorators(array('ViewHelper'));
    }
}