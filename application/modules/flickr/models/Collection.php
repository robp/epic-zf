<?php

class Flickr_Model_Collection extends EPIC_Model_Abstract
{
    protected $_id;
    protected $_child_count;
    protected $_datecreate;
    protected $_iconlarge;
    protected $_iconsmall;
    protected $_server;
    protected $_secret;
    protected $_title;
    protected $_description;
    protected $_photosetIds = array();
    protected $_photosets;
    
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }
    
    public function setChildCount($child_count)
    {
        $this->_child_count = $child_count;
        return $this;
    }

    public function getChildCount()
    {
        return $this->_child_count;
    }
    
    public function setDatecreate($datecreate)
    {
        $this->_datecreate = $datecreate;
        return $this;
    }

    public function getDatecreate()
    {
        return $this->_datecreate;
    }
    
    public function setIconlarge($iconlarge)
    {
        $this->_iconlarge = $iconlarge;
        return $this;
    }

    public function getIconlarge()
    {
        return $this->_iconlarge;
    }
    
    public function setIconsmall($iconsmall)
    {
        $this->_iconsmall = $iconsmall;
        return $this;
    }

    public function getIconsmall()
    {
        return $this->_iconsmall;
    }
    
    public function setServer($server)
    {
        $this->_server = $server;
        return $this;
    }

    public function getServer()
    {
        return $this->_server;
    }
    
    public function setSecret($secret)
    {
        $this->_secret = $secret;
        return $this;
    }

    public function getSecret()
    {
        return $this->_secret;
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

    public function setDescription($description)
    {
        $this->_description = $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function setPhotosetIds($photosetIds)
    {
        $this->_photosetIds = $photosetIds;
        return $this;
    }

    public function getPhotosetIds()
    {
        return $this->_photosetIds;
    }
    
    public function getPhotosets()
    {
        if (!isset($this->_photosets)) {
            $this->_photosets = array();
            foreach ($this->getPhotosetIds() as $photosetId) {
                $photoset = new Flickr_Model_Photoset();
                $photoset->find($photosetId);
                $this->_photosets[] = $photoset;
            }
        }
        return $this->_photosets;
    }
}
