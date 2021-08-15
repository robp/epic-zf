<?php

class Blogger_Model_ServiceApi_Blog extends EPIC_Model_ServiceApi_Abstract 
{
    protected $_adapterClass = 'EPIC_Webservice_Adapter_Gdata';

//    public function __construct() {
//        $config = Zend_Registry::get('config');
//        $this->_adapterOptions = $config->modules->blogger->api;
//        parent::__construct();
//    }
    
    public function find($id)
    {
        // Get the blog by id.
        $query = new Zend_Gdata_Query('http://www.blogger.com/feeds/' . $id . '/posts/default');
        $query->setParam('max-entries', 1);
        $result = $this->getAdapter()->method('getFeed', $query);
        return array($result);
    }
}
