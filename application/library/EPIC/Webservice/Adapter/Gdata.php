<?php

class EPIC_Webservice_Adapter_Gdata extends EPIC_Webservice_Adapter_Abstract
{
//    protected $_config = array(
//        'url' => 'http://www.blogger.com/feeds/'
//    );
//    
//    protected $_user;
    
    protected function _checkRequiredOptions(array $config)
    {
        parent::_checkRequiredOptions($config);

//        // We need at least an API key.
//        if (! array_key_exists('userId', $config)) {
//            /** @see EPIC_Webservice_Adapter_Exception */
//            throw new EPIC_Webservice_Adapter_Exception("Configuration array must have a key for 'userId' that names the API access key");
//        }
    }
    
    public function connect()
    {
       // Create the REST client.
        $this->_connection = new Zend_Gdata();
    }

    public function method($method, $query)
    {
        return $this->_connection->$method($query);
    }
}