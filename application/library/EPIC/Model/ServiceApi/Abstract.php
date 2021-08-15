<?php

abstract class EPIC_Model_ServiceApi_Abstract extends EPIC_Webservice_Api_Abstract
{
    /** Webservice URL */
    protected $_adapterClass;
    protected $_adapterOptions;

    public function __construct() {
        if (!isset($this->_adapterOptions)) {
            $this->_adapterOptions = new Zend_Config(array());
        }
        
        if (isset($this->_adapterOptions->registryKey) && Zend_Registry::isRegistered($this->_adapterOptions->registryKey)) {
            $config = $this->_adapterOptions->registryKey;
        } else {
            $adapter = new $this->_adapterClass($this->_adapterOptions);
            if (isset($this->_adapterOptions->registryKey)) {
                Zend_Registry::set($this->_adapterOptions->registryKey, $adapter);
            }
            $config = array(self::ADAPTER => $adapter);
        }
        parent::__construct($config);
    }
    
    public function init() {
        $this->getAdapter()->connect();
    }
}
