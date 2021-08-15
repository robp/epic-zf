<?php
class Node_Validate_SlugExists extends Zend_Validate_Abstract
{
    const NOT_EXIST = 'notExist';
    
    protected $_messageTemplates = array(
        self::NOT_EXIST => 'Slug does not exist.'
    );
    
    public function isValid($value, $context = null)
    {
        $value = (string) $value;
        $this->_setValue($value);

        $node = Doctrine_Core::getTable('Node_Model_Node')->findOneBySlug($value);

        if (isset($node->slug)) {
            return true;
        }
        
        $this->_error(self::NOT_EXIST);
        return false;
    }
}