<?php

class Flickr_Model_Tag extends EPIC_Model_Abstract
{
    protected $_id;
    protected $_author;
    protected $_raw;
    protected $_machine_tag;
    protected $_tag;
    
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setAuthor($author)
    {
        $this->_author = $author;
        return $this;
    }

    public function getAuthor()
    {
        return $this->_author;
    }
    
    public function setRaw($raw)
    {
        $this->_raw = $raw;
        return $this;
    }

    public function getRaw()
    {
        return $this->_raw;
    }
    
    public function setMachineTag($machineTag)
    {
        $this->_machine_tag = $machineTag;
        return $this;
    }

    public function getMachineTag()
    {
        return $this->_machine_tag;
    }

    public function setTag($tag)
    {
        $this->_tag = $tag;
        return $this;
    }

    public function getTag()
    {
        return $this->_tag;
    }
}