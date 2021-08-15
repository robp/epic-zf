<?php

/**
 * AdminController
 * 
 * @author
 * @version 
 */

class User_AdminController extends Zend_Controller_Action
{

    public function indexAction()
    {
    }
    
    public function listAction()
    {
        $users = Doctrine_Core::getTable('User_Model_User')->findAll();
        $this->view->users = $users;
    }
    
    public function createAction()
    {
        // action body
        $form = new User_Form_Create();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) { 
//                $form->process($user);
                
                $user = new User_Model_User();
                $user->fromArray($form->getValues());
                $user->password = md5($form->getValue('new_password'));
                $user->save();
                    
                try {
                    $form->processSubForms();
                }
                catch (Exception $e) {
                    switch ($e->getCode()) {
                        default:
                            $this->_messages[] = new EPIC_Model_Message(
                                EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                    }
                }

                if (empty($e)) {
                    $this->_helper->flashMessenger->addMessage("User '". $user->username . "' created.");
                    $this->_helper->redirector->gotoRoute(array('action' => 'edit', 'id' => $user->id), 'adminTask');
                }
            }
        }

        $this->view->form = $form;
    }
    
    public function editAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $user = Doctrine_Core::getTable('User_Model_User')->find($id);
        $form = new User_Form_Edit(array('user' => $user));
        
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getParam('delete')) {
                $this->_helper->redirector->gotoRoute(array('action' => 'delete'), 'adminTask');
            }
            
            if ($form->isValid($this->getRequest()->getPost())) {
//                $form->process($user);
                
                $user->fromArray($form->getValues());
                if ($form->getValue('new_password')) {
                    $user->password = md5($form->getValue('new_password'));
                }
                if ($form->getValue('Roles') == NULL) {
                    $user->unlink('Roles');
                }
                $user->save();
                    
                try {
                    $form->processSubForms(array('user' => $user));
                }
                catch (Exception $e) {
                    switch ($e->getCode()) {
                        default:
                            $this->_messages[] = new EPIC_Model_Message(
                                EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                    }
                }

                if (empty($e)) {
                    $this->_helper->flashMessenger->addMessage('Changes saved.');
                    $this->_helper->redirector->gotoUrl(Zend_Registry::get('session')->referer);
                }
            }
        }
        else {
            $form->setDefaults($user->toArray());
        }
        
        $this->view->user = $user;
        $this->view->form = $form;
    }
    
    public function deleteAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $user = Doctrine_Core::getTable('User_Model_User')->find($id);
        
        $form = new User_Form_Delete();
        
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getParam('cancel')) {
                $this->_helper->redirector->gotoUrl(Zend_Registry::get('session')->referer);
            }

            if ($form->isValid($this->getRequest()->getPost())) {
                $user->delete();

                try {
                    $form->processSubForms(array('user' => $user));
                }
                catch (Exception $e) {
                    switch ($e->getCode()) {
                        default:
                            $this->_messages[] = new EPIC_Model_Message(
                                EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                    }
                }

                if (empty($e)) {
                    $this->_helper->flashMessenger->addMessage("User '" . $user->username . "' deleted.");
                    $this->_helper->redirector->gotoRoute(array('action' => 'list'), 'adminTask');
                }
            }
        }
        
        $this->view->user = $user;
        $this->view->form = $form;
    }

    public function rolesAction()
    {
        $q = Doctrine_Query::create()
            ->from('User_Model_Role r')
            ->where('NOT EXISTS (SELECT rp.parent_id FROM User_Model_RoleParent rp WHERE rp.child_id = r.id)')
            ->orderBy('r.name');
        
        $roles = $q->execute();
        $this->view->roles = $roles;
    }
    
    public function rolecreateAction()
    {
        // action body
        $form = new User_Form_Role_Create();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) { 
//                $form->process($user);
                
                $role = new User_Model_Role();
                $role->fromArray($form->getValues());
                $role->save();

//                $parent_ids = $form->getValue('parent_ids');
//                
//                if (!empty($parent_ids)) {
//                    foreach ($parent_ids as $parent_id) {
//                        $rp = new User_Model_RoleParent();
//                        $rp->child_id = $role->id;
//                        $rp->parent_id = $parent_id;
//                        $rp->save();
//                    }
//                }
//                
                try {
                    $form->processSubForms(array('role' => $role));
                }
                catch (Exception $e) {
                    switch ($e->getCode()) {
                        default:
                            $this->_messages[] = new EPIC_Model_Message(
                                EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                    }
                }

                if (empty($e)) {
                    $this->_helper->flashMessenger->addMessage("Role '". $role->name . "' created.");
                    $this->_helper->redirector->gotoRoute(array('action' => 'roles'), 'adminTask');
                }
            }
        }

        $this->view->form = $form;
    }

    public function roleeditAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $role = Doctrine_Core::getTable('User_Model_Role')->find($id);
        
        $form = new User_Form_Role_Edit(array('role' => $role));
        
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getParam('delete')) {
                $this->_helper->redirector->gotoRoute(array('action' => 'roledelete'), 'adminTask');
            }
            
            if ($form->isValid($this->getRequest()->getPost())) {
//                $form->process($user);
                
                $role->fromArray($form->getValues());
                if ($form->getValue('Parents') == NULL) {
                    $user->unlink('Parents');
                }
//                $role->unlink('Parents');
//                
//                $parent_ids = $form->getValue('parent_ids');
//                
//                if (!empty($parent_ids)) {
//                    $parents = new Doctrine_Collection(Doctrine_Core::getTable('User_Model_Role'));
//                    foreach ($parent_ids as $parent_id) {
//                        $parents[] = Doctrine_Core::getTable('User_Model_Role')->find($parent_id);
//                    }
//                    
//                    $role->Parents = $parents;
//                }
//                
                $role->save();
                
                try {
                    $form->processSubForms(array('role' => $role));
                }
                catch (Exception $e) {
                    switch ($e->getCode()) {
                        default:
                            $this->_messages[] = new EPIC_Model_Message(
                                EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                    }
                }

                if (empty($e)) {
                    $this->_helper->flashMessenger->addMessage('Changes saved.');
                    $this->_helper->redirector->gotoUrl(Zend_Registry::get('session')->referer);
                }
            }
        }
        else {
            $form->setDefaults($role->toArray());
        }
        
        $this->view->role = $role;
        $this->view->form = $form;
    }
    
    public function roledeleteAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $role = Doctrine_Core::getTable('User_Model_Role')->find($id);
                
        $form = new User_Form_Role_Delete();
        
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getParam('cancel')) {
                $this->_helper->redirector->gotoUrl(Zend_Registry::get('session')->referer);
            }

            if ($form->isValid($this->getRequest()->getPost())) {
                $role->delete();

                try {
                    $form->processSubForms(array('role' => $role));
                }
                catch (Exception $e) {
                    switch ($e->getCode()) {
                        default:
                            $this->_messages[] = new EPIC_Model_Message(
                                EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                    }
                }

                if (empty($e)) {
                    $this->_helper->flashMessenger->addMessage("Role '" . $role->name . "' deleted.");
                    $this->_helper->redirector->gotoRoute(array('action' => 'roles'), 'adminTask');
                }
            }
        }
        
        $this->view->role = $role;
        $this->view->form = $form;
    }

    public function privilegesAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $roles = array();
        
        if ($id) {
            $role = Doctrine_Core::getTable('User_Model_Role')->find($id);
            if (!empty($role->id)) {
                $roles = array($role);
            }
        }
        if (!count($roles)) {
            $roles = Doctrine_Core::getTable('User_Model_Role')->findAll();
        }

        if ($this->getRequest()->isPost()) {
            foreach ($roles as $role) {
                if ($this->getRequest()->getParam($role->id)) {

                    $role->unlink('Privileges');

                    $privileges = new Doctrine_Collection(Doctrine_Core::getTable('User_Model_RolePrivilege'));

                    foreach ($this->getRequest()->getParam($role->id) as $privilege_id => $value) {
                        $rp = new User_Model_RolePrivilege();
                        $rp->role_id = $role->id;
                        $rp->privilege_id = $privilege_id;
                        
                        switch ($value) {
                            case 1:
                                $rp->allowed = TRUE;
                                $privileges[] = $rp;
                                break;
                            case -1:
                                $rp->allowed = FALSE;
                                $privileges[] = $rp;
                                break;
                        }
                    }

                    if (count($privileges)) {
                        $role->RolePrivileges = $privileges;
                    }

                    $role->save();
                    
                    try {
//                        $form->processSubForms(array('role' => $role));
                    }
                    catch (Exception $e) {
                        switch ($e->getCode()) {
                            default:
                                $this->_messages[] = new EPIC_Model_Message(
                                    EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                        }
                    }
    
                    if (empty($e)) {
                        $this->_helper->flashMessenger->addMessage("Changes saved.");
                        $this->_helper->redirector->gotoRoute(array('module' => 'user', 'action' => 'roles'), 'adminTask', TRUE);
                    }
                    
                }
            }
        }
        
        $resources = Doctrine_Core::getTable('User_Model_Resource')->findAll();
        
        $this->view->roles = $roles;
        $this->view->resources = $resources;
    }
}
