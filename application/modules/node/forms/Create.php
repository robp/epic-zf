<?php

class Node_Form_Create extends Node_Form_Edit
{

    public function init()
    {
        parent::init();
        if ($this->getElement('published')) {
            $this->getElement('published')->setChecked(TRUE);
        }
        $this->getDisplayGroup('buttons')->removeElement('delete');
    }
}
