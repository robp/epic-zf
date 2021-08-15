<?php

class Taxonomy_Form_Term_Create extends Taxonomy_Form_Term_Edit
{

    public function init()
    {
        parent::init();
        $this->getDisplayGroup('buttons')->removeElement('delete');
    }
}
