<?php

class User_Form_Register extends EPIC_Form
{
    
    public function init()
    {
        $username = new User_Form_Element_Username('username', array('required' => TRUE));
        $username->addValidator(
            new EPIC_Validate_Doctrine_NoRecordExists(array('table' => 'User_Model_User', 'field' => 'username'))
        );
        $validator = $username->getValidator('StringLength');
        $this->addElement($username);

        $emailAddress = new User_Form_Element_EmailAddress('email_address', array('required' => TRUE));
        $emailAddress->addValidator(
            new EPIC_Validate_Doctrine_NoRecordExists(array('table' => 'User_Model_User', 'field' => 'email_address'))
        );
        $emailAddress->setDescription($emailAddress->getDescription() . ' Confirmation by email is required.');
        $this->addElement($emailAddress);
        
        $password = new User_Form_Element_Password('password', array('required' => TRUE));
        $password->addValidator(new User_Validate_PasswordConfirmation('password_confirm'));
        $validator = $password->getValidator('StringLength');
        $this->addElement($password);

        $passwordConfirm = new User_Form_Element_Password('password_confirm', array('required' => TRUE));
        $passwordConfirm->setLabel('Password Confirm')
                        ->setDescription('Enter the password again to confirm.');
        $this->addElement($passwordConfirm);
        
        $this->addSubForm(new Captcha_Form_SubForm_Captcha(), 'captcha');
        
        $this->getElement('submit')->setLabel('Register');
    }

    public function process()
    {
        $now = new Zend_Date();
        $user = new User_Model_User();
        $user->fromArray($this->getValues());
        $user->password = md5($this->getValue('password'));
        $user->confirm_code = md5($now->get(Zend_Date::TIMESTAMP).$_SERVER['REMOTE_ADDR'].$this->getValue('username'));
        $user->save();

        return $user;
    }
}
