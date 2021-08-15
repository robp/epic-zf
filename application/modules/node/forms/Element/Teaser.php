<?php

class Node_Form_Element_Teaser extends EPIC_Form_Element_ResizeableTextarea 
{
    
    public function init()
    {
        parent::init();
        $this->setLabel('Teaser')
             ->setOrder(55)
             ->setAttribs(array(
                 'rows' => 5,
                 'class' => 'resizable'
                 ));
    }
}