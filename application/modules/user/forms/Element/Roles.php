<?php

class User_Form_Element_Roles extends User_Form_Role_Element_Parents 
{
    
    public function init()
    {
        parent::init();
        $this->setLabel('Roles')
             ->setDescription('Select the roles that this user will inherit privileges from.');

        foreach ($this->getMultiOptions() as $id => $name) {
            $role = Doctrine_Core::getTable('User_Model_Role')->find($id);
            if (!$role->selectable) {
                $disable = $this->getAttrib('disable') ? $this->getAttrib('disable') : array();
                $this->setAttrib('disable', array_merge($disable, array($id)));
            }
        }
    }
}