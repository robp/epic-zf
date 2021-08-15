<?php

class User_Form_Role_Edit extends EPIC_Form
{
    
    public function init()
    {
        $exclude = NULL;
        $role = NULL;
        
        if (!empty($this->getAttrib('role')->name)) {
            $role = $this->getAttrib('role');
            $exclude = array('field' => 'name','value' => $role->name);
        }
        
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Role name')
             ->setDescription('The name for this role. Example: "moderator", "editorial board", "site architect".')
             ->setRequired(TRUE)
             ->setFilters(array('StripTags', 'StringTrim'))
             ->addValidator(
                 new EPIC_Validate_Doctrine_NoRecordExists(array('table' => 'User_Model_Role', 'field' => 'name', 'exclude' => $exclude))
             );
        $this->addElement($name);

        $description = new EPIC_Form_Element_ResizeableTextarea('description');
        $description->setLabel('Description')
                    ->setDescription('A description of the role.')
                    ->setFilters(array('StripTags', 'StringTrim'));
        $this->addElement($description);
        
        
        $parent = new User_Form_Role_Element_Parents('Parents', array('role' => $role));
        $this->addElement($parent);
        
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

        $role = $this->getAttrib('role');
        
        $parentIds = array();

        foreach ($role->Parents as $parent) {
            $parentIds[] = $parent->id;
        }
        
        $this->getElement('Parents')->setValue($parentIds);
    }
}
