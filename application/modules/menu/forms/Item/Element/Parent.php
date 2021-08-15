<?php

class Menu_Form_Item_Element_Parent extends Zend_Form_Element_Select 
{
    
    public function init()
    {
        $this->setLabel('Parent Item')
             ->setDescription('Select the parent menu or menu item.')
             ->setFilters(array('StripTags', 'StringTrim'));
             
        $menus = Doctrine_Core::getTable('Menu_Model_Menu')->findAll();
        
        foreach ($menus as $menu) {
            $this->addMultiOption('menu_' . $menu->id, '<'.$menu->title.'>');
            if ($menu->id != 1 && !$this->getValue()) {
                $this->setValue('menu_' . $menu->id);
            }
            $this->addMultiOptions($this->_itemTree($menu->getChildItems()));
        }
    }
    
    private function _itemTree($items, &$results = array(), $depth = 1)
    {
        foreach ($items as $item) {
            $results['item_' . $item->id] = str_repeat('--', $depth) . ' ' . $item->label;
            $results = $this->_itemTree($item->getChildItems(), $results, $depth+1);
        }

        return $results;
    }
}
