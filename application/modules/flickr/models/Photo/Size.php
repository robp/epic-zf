<?php

class Flickr_Model_Photo_Size extends EPIC_Model_Abstract
{
    protected $_label;
    protected $_width;
    protected $_height;
    protected $_source;
    protected $_url;
    
    public function setLabel($label)
    {
        $this->_label = $label;
        return $this;
    }

    public function getLabel()
    {
        return $this->_label;
    }

    public function setWidth($width)
    {
        $this->_width = $width;
        return $this;
    }

    public function getWidth()
    {
        return $this->_width;
    }
    
    public function setHeight($height)
    {
        $this->_height = $height;
        return $this;
    }

    public function getHeight()
    {
        return $this->_height;
    }
    
    public function setSource($source)
    {
        $this->_source = $source;
        return $this;
    }

    public function getSource()
    {
        return $this->_source;
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
}