<?php

class User_LoginController extends Zend_Controller_Action
{
    public function preDispatch() {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'index');
        }
    }

    public function indexAction()
    {
        // action body
        $form = new User_Form_Login();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) { 
                try {
//                    $form->process();
                    $auth = Zend_Auth::getInstance();
                    $authAdapter = new User_Auth_Adapter_Doctrine($form->getValue('username'), $form->getValue('password'));
                    $result = $auth->authenticate($authAdapter);
                    
                    switch ($result->getCode()) {
                        case Zend_Auth_Result::SUCCESS:
                            break;
                        default:
                            foreach ($result->getMessages() as $message) {
                                throw new EPIC_Form_Exception($message, $result->getCode());
                            }
                            break;
                    }
                    
                    $form->processSubForms();
                }
                catch (Exception $e) {
                    switch ($e->getCode()) {
                        case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
                        case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
                        default:
                            $this->_messages[] = new EPIC_Model_Message(EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                    }
                }

                if (empty($e)) {
                    $this->_helper->flashMessenger->addMessage('Logged in.');
                    $this->_helper->redirector('index', 'index');
                }
            }
        }
        
        $this->view->form = $form;
    }
}
