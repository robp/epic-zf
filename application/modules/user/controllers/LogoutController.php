<?php

class User_LogoutController extends Zend_Controller_Action
{
    public function preDispatch() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'login');
        }
    }

    public function indexAction()
    {
        // action body
        if (Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
            $this->_helper->flashMessenger->addMessage('Logged out.');
        }
        else {
            $this->_helper->flashMessenger->addMessage('Not logged in.');
        }
        $this->_helper->redirector('index', 'login');
    }
}
