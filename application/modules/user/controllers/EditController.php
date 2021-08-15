<?php

class User_EditController extends Zend_Controller_Action
{

    public function preDispatch()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'login');
        }
    }

    public function indexAction()
    {
        $user = Zend_Registry::get('user');
        $this->view->user = $user;
        $this->_helper->viewRenderer('profile');
    }

    public function otherAction()
    {
        if (is_numeric($this->getRequest()->getParam('identifier'))) {
            $this->_forward('id');
        }
        else {
            $this->_forward('slug');
        }
    }
    
    public function idAction()
    {
        // action body
        $filters = array(
            'identifier' => 'Digits',
        );
        $validators = array(
            'identifier' => array(
                'presence' => 'required',
                'NotEmpty',
            ),
        );

        $input = new Zend_Filter_Input($filters, $validators, $this->getRequest()->getParams());
        
        if ($input->isValid()) {
            $user = Doctrine_Core::getTable('User_Model_User')->find($input->identifier);
//            $this->view->layout()->title = $node->title;
            $this->view->user = $user;
        }
        
        $this->_helper->viewRenderer('profile');
    }
    
    public function slugAction()
    {
        // action body
        $options = array(
        	'filterNamespace' => 'EPIC_Filter',
            'validatorNamespace' => 'User_Validate');;

        $filters = array(
            'identifier' => 'Slug',
        );
        $validators = array(
            'identifier' => array(
                'presence' => 'required',
                'NotEmpty',
                'SlugExists',
            ),
        );

        $input = new Zend_Filter_Input($filters, $validators, $this->getRequest()->getParams(), $options);
        
        if ($input->isValid()) {
            $user = Doctrine_Core::getTable('User_Model_User')->findOneBySlug($input->identifier);
//            $this->view->layout()->title = $node->title;
            $this->view->user = $user;
        }
        else {
            foreach ($input->getMessages() as $messageArr) {
                foreach ($messageArr as $message) {
                    $this->_messages[] = new EPIC_Model_Message(
                        EPIC_Model_Message::TYPE_WARN, NULL, $message
                    );
                }
            }
        }

        $this->_helper->viewRenderer('profile');
    }
}
