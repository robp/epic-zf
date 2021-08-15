<?php

class Flickr_Model_ServiceApi_Photoset extends EPIC_Model_ServiceApi_Abstract 
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
        $result = $this->getAdapter()->method('flickr.photosets.getInfo')
           ->photoset_id($id)
           ->get();

        if (isset($result->err)) {
            throw new EPIC_Model_ServiceApi_Exception($result->err['msg'] . ' (Error code ' . $result->err['code'] . ')');
        }
        
        return array($result->photoset);
    }
}
