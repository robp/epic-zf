<?php

class User_ListController extends Zend_Controller_Action
{

    public function preDispatch()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'login');
        }
    }

    public function indexAction()
    {
        $users = Doctrine_Core::getTable('User_Model_User')->findAll();
        $this->view->users = $users;
    }
}
