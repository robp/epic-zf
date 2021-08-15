<?php

/**
 * AdminController
 * 
 * @author
 * @version 
 */

class Node_AdminController extends Zend_Controller_Action
{

    public function indexAction()
    {
        
    }

    public function listAction()
    {
        $nodes = Doctrine_Core::getTable('Node_Model_Node')->findAll();
        $this->view->nodes = $nodes;
    }

    public function createAction()
    {
        $type = $this->getRequest()->getParam('type');
        
        if ($type) {
            $nodeType = Doctrine_Core::getTable('Node_Model_Type')->findOneByName($type);
        }
        
        if (isset($nodeType)) {
            // action body
            $form = new Node_Form_Create(array('type' => $nodeType));
            
            if ($this->getRequest()->isPost()) {
                if ($form->isValid($this->getRequest()->getPost())) { 
//                    $form->process($node);
                    
                    $class = $nodeType->class;
                    $node = new $class();
                    $node->fromArray($form->getValues());
                    $node->User = Zend_Registry::get('user');
                    $node->save();
                        
                    try {
                        $form->processSubForms(array('node' => $node));
                    }
                    catch (Exception $e) {
                        switch ($e->getCode()) {
                            default:
                                $this->_messages[] = new EPIC_Model_Message(
                                    EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                        }
                    }
    
                    if (empty($e)) {
                        $this->_helper->flashMessenger->addMessage("Node '". $node->title . "' created.");
                        $this->_helper->redirector->gotoUrl($node->getUrl());
                    }
                }
            }
            
            $this->view->nodeType = $nodeType;
            $this->view->form = $form;
        }
        else {
            $nodeTypes = Doctrine_Core::getTable('Node_Model_Type')->findAll();
            $this->view->nodeTypes = $nodeTypes;
            $this->_helper->viewRenderer('chooseType');
        }
    }
    
    public function editAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $node = Doctrine_Core::getTable('Node_Model_Node')->find($id);
        
        // Touch the Fields relationship to load the data.
        $node->Fields;
        
        $form = new Node_Form_Edit(array('node' => $node));
        
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getParam('delete')) {
                $this->_helper->redirector->gotoRoute(array('action' => 'delete'), 'adminTask');
            }
            
            if ($form->isValid($this->getRequest()->getPost())) {
//                $form->process($user);
                
                $node->fromArray($form->getValues());
                $node->save();
                    
                try {
                    $form->processSubForms(array('node' => $node));
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
            // Call set defaults so our subforms can do things.
            $form->setDefaults($node->toArray());
        }
        
        $this->view->node = $node;
        $this->view->form = $form;
    }
    
    public function deleteAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $node = Doctrine_Core::getTable('Node_Model_Node')->find($id);
        
        $form = new Node_Form_Delete(array('node' => $node));
        
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getParam('cancel')) {
                $this->_helper->redirector->gotoUrl(Zend_Registry::get('session')->referer);
            }

            if ($form->isValid($this->getRequest()->getPost())) {
                $node->delete();

                try {
                    $form->processSubForms(array('node' => $node));
                }
                catch (Exception $e) {
                    switch ($e->getCode()) {
                        default:
                            $this->_messages[] = new EPIC_Model_Message(
                                EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                    }
                }

                if (empty($e)) {
                    $this->_helper->flashMessenger->addMessage("Node '" . $node->title . "' deleted.");
                    $this->_helper->redirector->gotoRoute(array('action' => 'list'), 'adminTask');
                }
            }
        }
        
        $this->view->node = $node;
        $this->view->form = $form;
    }
    
    public function typesAction()
    {
        $types = Doctrine_Core::getTable('Node_Model_Type')->findAll();
        $this->view->types = $types;
    }
    
    public function typeeditAction()
    {
        $name = $this->getRequest()->getParam('name');
        $type = Doctrine_Core::getTable('Node_Model_Type')->findOneByName($name);
        
        // Access Route so we can use it in our forms.
//        $type->Route;
        
        $form = new Node_Form_TypeEdit();
        
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getParam('delete')) {
                $this->_helper->redirector->gotoRoute(array('action' => 'typedelete'), 'adminTask');
            }
            
            if ($form->isValid($this->getRequest()->getPost())) {
//                $form->process($user);
                
                $type->fromArray($form->getValues());
                $type->save();
                    
                try {
                    $form->processSubForms(array('type' => $type));
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
            $form->setDefaults($type->toArray());
        }
        
        $this->view->type = $type;
        $this->view->form = $form;
    }}
