<?php

class Menu_Form_Node_Form_Edit_SubForm extends EPIC_Form_SubForm
{

    public function __construct($options = null)
    {
        $acl = Zend_Registry::get('acl');
        $user = Zend_Registry::get('user');
        
        if ($user->isAllowed('menu:menus', 'administer')) {
            parent::__construct($options);
        }
    }
        
    public function init()
    {
        $this->setLegend('Menu settings')
             ->setOrder(15);

        $delete = new EPIC_Form_Element_CheckboxOption('delete');
        $delete->setLabel('Delete this menu item')
               ->setDescription('Tick this option to delete the menu item.')
               ->setOrder(30);
        $this->addElement($delete);

        $label = new Menu_Form_Item_Element_Label('label');
        $label->setOrder(90);
        $this->addElement($label);
        
        $parent = new Menu_Form_Item_Element_Parent('parent');
        $parent->setOrder(120);
        $this->addElement($parent);
        
        $order = new Menu_Form_Item_Element_Order('order');
        $order->setOrder(160);
        $this->addElement($order);
    }
    
    public function setDefaults(array $defaults)
    {
        parent::setDefaults($defaults);
        
        $item = Menu_Model_Item::getByNodeId($defaults['id']);

        if (!empty($item->id)) {
            $this->getElement('label')->setValue($item->label)
                                      ->setRequired(TRUE);
                                      
            if ($item->parent_id) {
                $parent = 'item_' . $item->parent_id;
            }
            else {
                $parent = 'menu_' . $item->menu_id;
            }
            $this->getElement('parent')->setValue($parent)
                                       ->setRequired(TRUE);
            
            $this->getElement('order')->setValue($item->order)
                                      ->setRequired(TRUE);
        }
        else {
            $this->removeElement('delete');
            $this->setAttrib('class', 'collapsibleClosed');
        }
    }
    
    public function isValid($data)
    {
        // If we have a menu item, and we're not deleting it,
        // then make these elements required.
        if (isset($data['delete']) && !$data['delete']) {
            $this->getElement('label')->setRequired(TRUE);
            $this->getElement('parent')->setRequired(TRUE);
            $this->getElement('order')->setRequired(TRUE);
        }
        return parent::isValid($data);
    }

    public function process($context = array())
    {
        $node = $context['node'];
        $item = Menu_Model_Item::getByNodeId($node->id);
        
        if (!empty($item->id) && $this->getValue('delete')) {
            $item->delete();
            $this->getElement('delete')->setChecked(FALSE);
            $this->getElement('label')->setValue('');
            $this->getElement('parent')->setValue('');
            $this->getElement('order')->setValue('');
        }
        elseif ($this->getValue('label')) {
            $route = Path_Core::getRouteByNodeId($node->id);

            if (empty($item->id)) {
                $item = new Menu_Model_Item();
            }
    
            $item->label = $this->getValue('label');
            $item->route = $route->name;
    
            list($type, $id) = explode('_', $this->getValue('parent'));
            
            if ($type == 'menu') {
                $item->menu_id = $id;
            }
            elseif ($type == 'item') {
                $parent = Doctrine_Core::getTable('Menu_Model_Item')->find($id);
                $item->menu_id = $parent->menu_id;
                $item->parent_id = $parent->id;
            }
            
            $item->order = $this->getValue('order');
            
            $item->module = $route->defaults['module'];
            $item->controller = $route->defaults['controller'];
            $item->action = $route->defaults['action'];
            $item->params = array('id' => $node->id);
    
            $item->save();
        }
    }
}
