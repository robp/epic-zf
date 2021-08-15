<?php

class Taxonomy_Form_Vocabulary_Create extends Taxonomy_Form_Vocabulary_Edit
{

    public function init()
    {
        parent::init();
        $this->getElement('required')->setChecked(TRUE);
        $this->getDisplayGroup('buttons')->removeElement('delete');
    }
}
