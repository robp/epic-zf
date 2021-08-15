<?php

class Path_Form_Node_Form_Delete_SubForm extends EPIC_Form_SubForm
{
    
    public function process($context = array())
    {
        // Delete a node's route entry, if it exists.
        $routeName = Path_Core::getNodeRouteName($context['node']->id);
        $route = Doctrine_Core::getTable('Menu_Model_Route')->findOneByName($routeName);

        if (!empty($route->id)) {
            $route->delete();
        }
    }
}
