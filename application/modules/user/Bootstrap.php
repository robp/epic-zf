<?php

class User_Bootstrap extends EPIC_Application_Module_Bootstrap {
    // Bootstrap the module

    protected function _initPlugins() {
        $bootstrap = $this->getApplication();
        $bootstrap->bootstrap('frontController');
        
        $front = $bootstrap->getResource('frontController');
//        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new User_Plugin_Acl());
    }
    
    protected function _initAcl() {
        $bootstrap = $this->getApplication();
        $bootstrap->bootstrap('doctrine');

        $acl = new Zend_Acl();
        $roles = Doctrine_Core::getTable('User_Model_Role')->findAll();
        $resources = Doctrine_Core::getTable('User_Model_Resource')->findAll();

        foreach ($resources as $resource) {
            $acl->addResource($resource);
        }
        
        foreach ($roles as $role) {
            $this->_addRole($acl, $role);
            
            foreach ($role->RolePrivileges as $rp) {
                if ($rp->allowed) {
                    $acl->allow($role, $rp->Privilege->Resource, $rp->Privilege->privilege);
                }
                else {
                    $acl->deny($role, $rp->Privilege->Resource, $rp->Privilege->privilege);
                }
            }
        }

        // Create a super-admin group for user 1.
        $role = new User_Model_Role();
        $role->name = 'super administrators';
        $acl->addRole($role);
        $acl->allow($role); // Allow super-administrator to do everything.
        
//        Zend_Debug::dump($acl);
        Zend_Registry::set('acl', $acl);
        return $acl;
    }

    protected function _initUser()
    {
        $bootstrap = $this->getApplication();
        $bootstrap->bootstrap('doctrine');
        $acl = Zend_Registry::get('acl');
        
        $user = NULL;

        if (Zend_Auth::getInstance()->hasIdentity()) {
            $user = Doctrine_Core::getTable('User_Model_User')->find(Zend_Auth::getInstance()->getIdentity());
            // Give user 1 all privileges by adding to 'super administrators' role.
            if ($user->id == 1) {
                $user->Roles[] = $acl->getRole('super administrators');
            }
        }
        else {
            $user = new User_Model_User();
            $role = Doctrine_Core::getTable('User_Model_Role')->find(1);
            $user->Roles[] = $role;
        }
        
        Zend_Registry::set('user', $user);
        return $user;
    }
    
    private function _addRole(Zend_Acl $acl, User_Model_Role $role) {
        // $acl->addRole() requires an actual array() of parents
        // instead of the $role->Parents Doctrine_Collection. 
        $parents = array();
        
        foreach ($role->Parents as $parent) {
            $parents[] = $parent;

            // Recursive call to add parent roles first.
            if (!$acl->hasRole($parent)) {
                $this->_addRole($acl, $parent);
            }
        }
        
        $acl->addRole($role, $parents);
    }
}
