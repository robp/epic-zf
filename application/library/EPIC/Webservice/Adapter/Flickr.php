<?php

class EPIC_Webservice_Adapter_Flickr extends EPIC_Webservice_Adapter_Abstract
{
    protected $_config = array(
        'url' => 'http://api.flickr.com/services/rest/'
    );
    
    protected $_user;
    
    protected function _checkRequiredOptions(array $config)
    {
        parent::_checkRequiredOptions($config);

        // We need at least am API key.
        if (! array_key_exists('key', $config)) {
            /** @see EPIC_Webservice_Adapter_Exception */
            throw new EPIC_Webservice_Adapter_Exception("Configuration array must have a key for 'key' that names the API access key");
        }
    }
    
    public function connect()
    {
       // Create the REST client.
        $this->_connection = new Zend_Rest_Client($this->_config['url']);

        // Get our Flickr user object.
        $result = $this->_connection->method('flickr.people.findByUsername')
           ->api_key($this->_config['key'])
           ->username($this->_config['username'])
           ->get();

        $this->_user = $result->user;
    }

    public function method($method)
    {
        return $this->_connection->method($method)
                                 ->api_key($this->_config['key'])
                                 ->user_id((string) $this->_user['nsid']);
    }
}