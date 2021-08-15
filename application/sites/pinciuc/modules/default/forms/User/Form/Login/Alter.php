<?php

class Default_Form_User_Form_Login_Alter
{
    
    public function alter($form)
    {
        $form->getElement('username')
             ->setDescription('Enter your pinciuc.com username.');
             
        $form->getElement('password')
             ->setDescription('Enter the password that accompanies your username.');
    }
}