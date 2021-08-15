<?php

class Menu_Form_Node_Form_Delete_SubForm extends EPIC_Form_SubForm
{
    
    public function process($context = array())
    {
        // Delete a node's menu item.
        $item = Menu_Model_Item::getByNodeId($context['node']->id);
        if (!empty($item->id)) {
            $item->delete();
        }
    }
}
