<?php

/**
 * AdminController
 * 
 * @author
 * @version 
 */

class Menu_AdminController extends Zend_Controller_Action
{

    public function indexAction()
    {
        
    }

    public function listAction()
    {
        $menus = Doctrine_Core::getTable('Menu_Model_Menu')->findAll();
        $this->view->menus = $menus;
    }

    public function createAction()
    {
        
        // action body
        $form = new Menu_Form_Menu_Create();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) { 
//                $form->process($user);
                
                $menu = new Menu_Model_Menu();
                $menu->fromArray($form->getValues());
                $menu->save();
                
                try {
                    $form->processSubForms(array('menu' => $menu));
                }
                catch (Exception $e) {
                    switch ($e->getCode()) {
                        default:
                            $this->_messages[] = new EPIC_Model_Message(
                                EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                    }
                }

                if (empty($e)) {
                    $this->_helper->flashMessenger->addMessage("Menu '". $menu->name . "' created.");
                    $this->_helper->redirector->gotoRoute(array('action' => 'list'), 'adminTask');
                }
            }
        }
        
        $this->view->form = $form;
    }
    
    public function editAction()
    {
        $name = $this->getRequest()->getParam('name');
        $menu = Doctrine_Core::getTable('Menu_Model_Menu')->findOneByName($name);
                
        $form = new Menu_Form_Menu_Edit();
        
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getParam('delete')) {
                $this->_helper->redirector->gotoRoute(array('action' => 'delete'), 'adminTask');
            }
            
            if ($form->isValid($this->getRequest()->getPost())) {
//                $form->process($user);
                
                $menu->fromArray($form->getValues());
                $menu->save();
                
                try {
                    $form->processSubForms(array('menu' => $menu));
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
            $form->setDefaults($menu->toArray());
        }
        
        $this->view->menu = $menu;
        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $name = $this->getRequest()->getParam('name');
        $menu = Doctrine_Core::getTable('Menu_Model_Menu')->findOneByName($name);
                        
        $form = new Menu_Form_Menu_Delete();
        
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getParam('cancel')) {
                $this->_helper->redirector->gotoUrl(Zend_Registry::get('session')->referer);
            }

            if ($form->isValid($this->getRequest()->getPost())) {
                $menu->delete();

                try {
                    $form->processSubForms(array('menu' => $menu));
                }
                catch (Exception $e) {
                    switch ($e->getCode()) {
                        default:
                            $this->_messages[] = new EPIC_Model_Message(
                                EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                    }
                }

                if (empty($e)) {
                    $this->_helper->flashMessenger->addMessage("Menu '" . $menu->name . "' deleted.");
                    $this->_helper->redirector->gotoRoute(array('action' => 'list'), 'adminTask');
                }
            }
        }
        
        $this->view->menu = $menu;
        $this->view->form = $form;
    }

    public function itemsAction()
    {
        $name = $this->getRequest()->getParam('name');
        $menu = Doctrine_Core::getTable('Menu_Model_Menu')->findOneByName($name);

        $items = $menu->getChildItems();
//        $items = Menu_Model_Menu::getItemsByMenuId($menu->id);

        $this->view->items = $items;
        $this->view->menu = $menu;
    }

    public function itemcreateAction()
    {
        $name = $this->getRequest()->getParam('name');
        $menu = Doctrine_Core::getTable('Menu_Model_Menu')->findOneByName($name);
                
        // action body
        $form = new Menu_Form_Item_Create();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) { 
//                $form->process($user);
                
                $item = new Menu_Model_Item();
                $item->fromArray($form->getValues());
                $item->Menu = $menu;
                $item->save();
                    
                try {
                    $form->processSubForms(array('item' => $item));
                }
                catch (Exception $e) {
                    switch ($e->getCode()) {
                        default:
                            $this->_messages[] = new EPIC_Model_Message(
                                EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                    }
                }

                if (empty($e)) {
                    $this->_helper->flashMessenger->addMessage("Item '". $item->label . "' created.");
                    $this->_helper->redirector->gotoRoute(array('action' => 'items'), 'adminTask');
                }
            }
        }
        
        $this->view->menu = $menu;
        $this->view->form = $form;
    }

    public function itemeditAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $item = Doctrine_Core::getTable('Menu_Model_Item')->find($id);
        
        $form = new Menu_Form_Item_Edit();
        
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getParam('delete')) {
                $this->_helper->redirector->gotoRoute(array('action' => 'itemdelete'), 'adminTask');
            }
            
            if ($form->isValid($this->getRequest()->getPost())) {
//                $form->process($user);
                
                $item->fromArray($form->getValues());
                $item->save();
                    
                try {
                    $form->processSubForms(array('item' => $item));
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
            $form->setDefaults($item->toArray());
        }
        
        $this->view->item = $item;
        $this->view->form = $form;
    }
    
    public function itemdeleteAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $item = Doctrine_Core::getTable('Menu_Model_Item')->find($id);
                        
        $form = new Menu_Form_Item_Delete();
        
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getParam('cancel')) {
                $this->_helper->redirector->gotoUrl(Zend_Registry::get('session')->referer);
            }

            if ($form->isValid($this->getRequest()->getPost())) {
                $item->delete();
                
                try {
                    $form->processSubForms(array('item' => $item));
                }
                catch (Exception $e) {
                    switch ($e->getCode()) {
                        default:
                            $this->_messages[] = new EPIC_Model_Message(
                                EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                    }
                }

                if (empty($e)) {
                    $this->_helper->flashMessenger->addMessage("Item '" . $item->label . "' deleted.");
                    $this->_helper->redirector->gotoRoute(array('action' => 'items', 'name' => $item->Menu->name), 'adminTask');
                }
            }
        }
        
        $this->view->item = $item;
        $this->view->form = $form;
    }
}
