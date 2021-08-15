<?php

class Blogger_Model_Author extends EPIC_Model_Abstract
{
    protected $_name;
    protected $_email;
    protected $_uri;
    
    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setEmail($email)
    {
        $this->_email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->_email;
    }
    
    public function setUri($uri)
    {
        $this->_uri = $uri;
        return $this;
    }

    public function getUri()
    {
        return $this->_uri;
    }
}
