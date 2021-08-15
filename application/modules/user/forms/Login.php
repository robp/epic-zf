<?php

class User_Form_Login extends EPIC_Form
{
    
    public function init()
    {
        $username = new User_Form_Element_Username('username', array('required' => TRUE));
        $username->removeValidator('StringLength');
        $this->addElement($username);

        $password = new User_Form_Element_Password('password');
        $password->removeValidator('StringLength');
        $this->addElement($password);

        $this->getElement('submit')->setLabel('Login');
    }

    public function process()
    {
        $auth = Zend_Auth::getInstance();
        $authAdapter = new User_Auth_Adapter_Doctrine($this->getValue('username'), $this->getValue('password'));
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
    }
}
