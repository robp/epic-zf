<?php

class Flickr_Model_Photoset extends EPIC_Model_Abstract
{
    protected $_id;
    protected $_owner;
    protected $_primary;
    protected $_secret;
    protected $_server;
    protected $_farm;
    protected $_photos;
    protected $_title;
    protected $_description;

    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setOwner($owner)
    {
        $this->_owner = $owner;
        return $this;
    }

    public function getOwner()
    {
        return $this->_owner;
    }

    public function setPrimary($primary)
    {
        $this->_primary = $primary;
        return $this;
    }

    public function getPrimary()
    {
        return $this->_primary;
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
    
    public function setServer($server)
    {
        $this->_server = $server;
        return $this;
    }

    public function getServer()
    {
        return $this->_server;
    }
    
    public function setFarm($farm)
    {
        $this->_farm = $farm;
        return $this;
    }

    public function getFarm()
    {
        return $this->_farm;
    }

    public function setPhotos($photos)
    {
        $this->_photos = $photos;
        return $this;
    }

    public function getPhotos()
    {
        return $this->_photos;
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
}