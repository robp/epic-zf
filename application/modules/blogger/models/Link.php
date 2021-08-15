<?php

class Blogger_Model_Link extends EPIC_Model_Abstract
{
    protected $_rel;
    protected $_href;
    protected $_type;
    protected $_title;
    
    public function setRel($rel)
    {
        $this->_rel = $rel;
        return $this;
    }

    public function getRel()
    {
        return $this->_rel;
    }
    
    public function setHref($href)
    {
        $this->_href = $href;
        return $this;
    }

    public function getHref()
    {
        return $this->_href;
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
    
    public function setTitle($title)
    {
        $this->_title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->_title;
    }
}
