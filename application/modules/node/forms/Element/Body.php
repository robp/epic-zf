<?php

class Node_Form_Element_Body extends EPIC_Form_Element_ResizeableTextarea
{
    
    public function init()
    {
        parent::init();
        $this->setLabel('Body')
             ->setOrder(50)
             ->setAttribs(array(
                 'rows' => 10,
                 'class' => 'resizable'
                 ));
    }
}