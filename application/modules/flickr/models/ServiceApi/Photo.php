<?php

class Flickr_Model_ServiceApi_Photo extends EPIC_Model_ServiceApi_Abstract 
{
    protected $_adapterClass = 'EPIC_Webservice_Adapter_Flickr';
    
    public function __construct() {
        $config = Zend_Registry::get('config');
        $this->_adapterOptions = $config->modules->flickr->api;
        parent::__construct();
    }
    
    public function find($id)
    {
        // Get the collection tree.
        $result = $this->getAdapter()->method('flickr.photos.getInfo')
                                     ->photo_id($id)
                                     ->get();

        if (isset($result->err)) {
            throw new EPIC_Model_ServiceApi_Exception($result->err['msg'] . ' (Error code ' . $result->err['code'] . ')');
        }
        
        return array($result->photo);
    }
    
    public function getSizes($id)
    {
        $result = $this->getAdapter()->method('flickr.photos.getSizes')
                                     ->photo_id($id)
                                     ->get();
        
        if (isset($result->err)) {
            throw new EPIC_Model_ServiceApi_Exception($result->err['msg'] . ' (Error code ' . $result->err['code'] . ')');
        }
        
        return array($result->sizes);
    }
    
    public function findByPhotosetId($photosetId, $options = array())
    {
        $method = $this->getAdapter()->method('flickr.photosets.getPhotos')
                                     ->photoset_id($photosetId);

        foreach ($options as $key => $val)
        {
            switch ($key)
            {
                case 'per_page':
                    $method->per_page($val);
                    break;
                case 'page':
                    $method->page($val);
                    break;
                default:
                    throw new EPIC_Model_ServiceApi_Exception('Invalid option \'' . $key . '\'');
                    break;
            }
        }

        $result = $method->get();

        if (isset($result->err)) {
            throw new EPIC_Model_ServiceApi_Exception($result->err['msg'] . ' (Error code ' . $result->err['code'] . ')');
        }
        
        return array($result->photoset);
    }
}
