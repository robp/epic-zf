<?php

class Menu_Form_Item_Element_Order extends Zend_Form_Element_Text 
{
    public function init()
    {
        $this->setLabel('Weight')
             ->setDescription('In the menu, the heavier items will sink and the lighter items will be positioned nearer the top.')
             ->setFilters(array('Int'));
    }
}
