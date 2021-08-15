<?php

class EPIC_Model_Message extends EPIC_Model_Abstract 
{
    protected $_type;
    protected $_code;
    protected $_text;
    
    const TYPE_INFO = 'info';
    const TYPE_WARN = 'warn';
    
    public function __construct($type = NULL, $code = NULL, $text = NULL)
    {
        $this->setType($type)
             ->setCode($code)
             ->setText($text);
    }
    
    public function setType($type)
    {
        $this->_type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function setCode($code)
    {
        $this->_code = $code;
        return $this;
    }

    public function getCode()
    {
        return $this->_code;
    }
    
    public function setText($text)
    {
        $this->_text = $text;
        return $this;
    }

    public function getText()
    {
        return $this->_text;
    }
}
