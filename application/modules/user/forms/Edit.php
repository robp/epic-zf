<?php

class User_Form_Edit extends EPIC_Form
{
    
    public function init()
    {
        $user = $this->getAttrib('user');
        
        $username = new User_Form_Element_Username('username', array('required' => TRUE));
        $username->addValidator(
            new EPIC_Validate_Doctrine_NoRecordExists(array('table' => 'User_Model_User', 'field' => 'username', 'exclude' => array('field' => 'username','value' => isset($user->username) ? $user->username : NULL)))
        );
        $validator = $username->getValidator('StringLength');
        $this->addElement($username);

        $emailAddress = new User_Form_Element_EmailAddress('email_address', array('required' => TRUE));
        $emailAddress->addValidator(
            new EPIC_Validate_Doctrine_NoRecordExists(array('table' => 'User_Model_User', 'field' => 'email_address', 'exclude' => array('field' => 'email_address','value' => isset($user->email_address) ? $user->email_address : NULL)))
        );
        $this->addElement($emailAddress);
        
        $this->addElement(new User_Form_Element_Roles('Roles'));
                    
        $this->addElement(new User_Form_Element_Status('status'));
        
        $password = new User_Form_Element_Password('new_password', array('required' => TRUE));
        $password->setRequired(FALSE);
        $password->addValidator(new User_Validate_PasswordConfirmation('new_password_confirm'));
        $validator = $password->getValidator('StringLength');
        $this->addElement($password);

        $passwordConfirm = new User_Form_Element_Password('new_password_confirm', array('required' => TRUE));
        $passwordConfirm->setRequired(FALSE);
        $passwordConfirm->setLabel('Password (again)')
                        ->setDescription('Enter the password again to confirm.');
        $this->addElement($passwordConfirm);

        $this->getDisplayGroup('buttons')->addElement(
            new Zend_Form_Element_Submit('delete', array(
            'label' => 'Delete...',
            'order' => 1001
        )));
        
        $this->getElement('submit')->setLabel('Save');
    }
    
    public function setDefaults(array $defaults)
    {
        parent::setDefaults($defaults);

        $user = $this->getAttrib('user');
        
        $roleIds = array();

        foreach ($user->Roles as $role) {
            $roleIds[] = $role->id;
        }
        
        $this->getElement('Roles')->setValue($roleIds);
    }
}
