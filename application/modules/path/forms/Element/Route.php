<?php 

class Path_Form_Element_Route extends Zend_Form_Element_Text
{
    
    public function init()
    {
        $this->setLabel('URL')
             ->setDescription('Optionally specify an alternative URL by which this node can be accessed. For example, type "about" when writing an about page. Use a relative path and don\'t add a trailing slash or the URL alias won\'t work.')
             ->setFilters(array('StripTags', 'StringTrim'));
//             ->addValidator(new EPIC_Validate_Doctrine_NoRecordExists(array('table' => 'Menu_Model_Route', 'field' => 'route')));
    }
}
