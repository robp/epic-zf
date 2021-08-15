<?php

class User_Form_Element_Status extends Zend_Form_Element_Radio
{
    
    public function init()
    {
        $this->setLabel('Status');
        $this->setRequired(TRUE);

        $statusCodes = array(
            User_Model_User::STATUS_DISABLED,
            User_Model_User::STATUS_CONFIRM,
            User_Model_User::STATUS_ACTIVE
        );
        foreach ($statusCodes as $code) {
            $this->addMultiOption($code, User_Model_User::getStatusName($code));
        }
    }
}