<?php

class User_RegisterController extends Zend_Controller_Action
{
    public function preDispatch() {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'index');
        }
    }

    public function indexAction()
    {
        // action body
        $form = new User_Form_Register();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) { 
                try {
                    $user = $form->process();
                    $form->processSubForms();
                }
                catch (Exception $e) {
                    $this->_messages[] = new EPIC_Model_Message(EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                }

                if (empty($e)) {
                    $this->view->confirm_code = $user->confirm_code;
                    
                    /* Send the email confirmation message. */
                    $message = $this->view->render(
                        $this->getViewScript(
                            'message'));
                        
                    $mail = new Zend_Mail();
                    $mail->setFrom(
                            $this->_moduleConfig->email->from->address, 
                            $this->_moduleConfig->email->from->name)
                        ->addTo(
                            $user->email_address) 
//                            $this->_moduleConfig->email->to->name)
                        ->setSubject($this->_moduleConfig->email->subject)
                        ->setBodyText($message); /*->send();*/
                    
                    $this->_helper->flashMessenger->addMessage($user->confirm_code);
                    
                    $redirector = $this->getHelper('Redirector');
                    $redirector->goto('success');
                }
            }
        }

        $this->view->form = $form;
    }
    
    public function successAction()
    {
        // action body 
    }
    
    public function confirmAction()
    {
        // action body
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $script = 'confirm-error';

        $confirm_code = $this->getRequest()->getParam('code');
        $user = Doctrine_Core::getTable('User_Model_User')->findOneByConfirmCode($confirm_code);
        
        if ($user) {
            if ($user->status == User_Model_User::STATUS_CONFIRM) {
                $user->status = User_Model_User::STATUS_ACTIVE;
                $user->save();
                $script = NULL;
            }
            else {
                $this->_messages[] = new EPIC_Model_Message(
                	EPIC_Model_Message::TYPE_WARN, NULL, "User is not awaiting confirmation."
                );
            }
        }
        else {
            $this->_messages[] = new EPIC_Model_Message(
            	EPIC_Model_Message::TYPE_WARN, NULL, "Confirmation code not found."
            );
        }

        echo $this->view->render($this->getViewScript($script));
    }
}
