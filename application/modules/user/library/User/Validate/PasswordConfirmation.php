<?php
class User_Validate_PasswordConfirmation extends Zend_Validate_Abstract
{
    const NOT_MATCH = 'notMatch';
    
    protected $_confirmField;
    
    protected $_messageTemplates = array(
        self::NOT_MATCH => 'Passwords did not match.'
    );
    
    public function __construct($confirmField)
    {
        $this->setConfirmField($confirmField);
    }
    
    public function setConfirmField($confirmField)
    {
        $this->_confirmField = $confirmField;
    }
    
    public function isValid($value, $context = null)
    {
        $value = (string) $value;
        $this->_setValue($value);
        
        if (is_array($context)) {
            if (isset($context[$this->_confirmField])
                && ($value == $context[$this->_confirmField]))
            {
                return true;
            }
        }
        elseif (is_string($context) && ($value == $context)) {
            return true;
        }
        
        $this->_error(self::NOT_MATCH);
        return false;
    }
}