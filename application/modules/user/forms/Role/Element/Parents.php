<?php

class User_Form_Role_Element_Parents extends Zend_Form_Element_MultiCheckbox 
{
    
    public function init()
    {
        $this->setLabel('Parent Roles')
             ->setDescription('Select the parent roles that this role will inherit privileges from.');

        $q = Doctrine_Query::create()
            ->from('User_Model_Role r')
            ->where('NOT EXISTS (SELECT rp.parent_id FROM User_Model_RoleParent rp WHERE rp.child_id = r.id)')
            ->orderBy('r.name');
        
        $roles = $q->execute();
             
        $options = array();
        $this->_itemTree($roles, $options);
        $this->addMultiOptions($options);
    }
    
    private function _itemTree($items, &$results, $depth = 0)
    {
        $role_id = $this->getAttrib('role') ? $this->getAttrib('role')->id : NULL; 
        foreach ($items as $role) {
            if ($role->id != $role_id) {
                $results[$role->id] = ' ' . str_repeat('--', $depth) . ' ' . $role->name;

//                $q = Doctrine_Query::create()
//                    ->from('User_Model_Role r')
//                    ->where('r.id IN (SELECT rp.child_id FROM User_Model_RoleParent rp WHERE parent_id = ?)', $role->id)
//                    ->orderBy('r.name');
//                
//                $children = $q->execute();

                $children = $role->Children;

                if (count($children)) {
                    $this->_itemTree($children, $results, $depth+1);
                }
            }
        }
    }
}
