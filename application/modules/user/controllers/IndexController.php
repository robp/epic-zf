<?php

class User_IndexController extends Zend_Controller_Action
{

    public function preDispatch()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'login');
        }
    }
    
    public function indexAction()
    {
        $this->_helper->redirector('index', 'view');
    }
}
