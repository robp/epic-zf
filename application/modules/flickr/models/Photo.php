<?php

class Flickr_Model_Photo extends EPIC_Model_Abstract
{
    protected $_id;
    protected $_secret;
    protected $_server;
    protected $_farm;
    protected $_dateuploaded;
    protected $_isfavorite;
    protected $_license;
    protected $_rotation;
    protected $_views;
    protected $_media;
    protected $_title;
    protected $_description;
    protected $_datePosted;
    protected $_dateTaken;
    protected $_dateLastupdate;
    protected $_comments;
    protected $_tags;
    protected $_url;
    
    protected $_sizes; 
    
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
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

    public function setDateuploaded($dateuploaded)
    {
        $this->_dateuploaded = $dateuploaded;
        return $this;
    }

    public function getDateuploaded()
    {
        return $this->_dateupladed;
    }
    
    public function setIsfavorite($isfavorite)
    {
        $this->_isfavorite = $isfavorite;
        return $this;
    }

    public function getIsfavorite()
    {
        return $this->_isfavorite;
    }
    
    public function setLicense($license)
    {
        $this->_license = $license;
        return $this;
    }

    public function getLicense()
    {
        return $this->_license;
    }
    
    public function setRotation($rotation)
    {
        $this->_rotation = $rotation;
        return $this;
    }

    public function getRotation()
    {
        return $this->_rotation;
    }
    
    public function setViews($views)
    {
        $this->_views = $views;
        return $this;
    }

    public function getViews()
    {
        return $this->_views;
    }
    
    public function setMedia($media)
    {
        $this->_media = $media;
        return $this;
    }

    public function getMedia()
    {
        return $this->_media;
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

    public function setDatePosted($datePosted)
    {
        $this->_datePosted = $datePosted;
        return $this;
    }

    public function getDatePosted()
    {
        return $this->_datePosted;
    }
    
    public function setDateTaken($dateTaken)
    {
        $this->_dateTaken = $dateTaken;
        return $this;
    }

    public function getDateTaken()
    {
        return $this->_dateTaken;
    }
    
    public function setDateLastupdate($dateLastupdate)
    {
        $this->_dateLastupdate = $dateLastupdate;
        return $this;
    }

    public function getDateLastupdate()
    {
        return $this->_dateLastupdate;
    }

    public function setComments($comments)
    {
        $this->_comments = $comments;
        return $this;
    }

    public function getComments()
    {
        return $this->_comments;
    }

    public function setTags($tags)
    {
        $this->_tags = $tags;
        return $this;
    }

    public function getTags()
    {
        return $this->_tags;
    }
    
    public function setUrl($url)
    {
        $this->_url = $url;
        return $this;
    }

    public function getUrl()
    {
        return $this->_url;
    }
    
    public function getSizes($size = NULL)
    {
        if (!isset($this->_sizes)) {
            $this->_sizes = $this->getMapper()->getSizes($this);
        }
        
        if ($size) {
            foreach ($this->getSizes() as $s) {
                if ($s->getLabel() == $size) {
                    return $s;
                }
            }
            // Specified size not found.
            return NULL;
        }
        
        return $this->_sizes;
    }

    public function findByPhotosetId($photosetId, $options = array())
    {
        return $this->getMapper()->findByPhotosetId($photosetId, $options);
    }
}