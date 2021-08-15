<?php

abstract class EPIC_Webservice_Adapter_Abstract
{
    /**
     * User-provided configuration
     *
     * @var array
     */
    protected $_config = array();

    /**
     * Web service connection
     *
     * @var object|resource|null
     */
    protected $_connection = null;


    /**
     * Constructor.
     *
     * $config is an array of key/value pairs or an instance of Zend_Config
     * containing configuration options.  These options are common to most adapters:
     *
     * dbname         => (string) The name of the database to user
     * username       => (string) Connect to the database as this username.
     * password       => (string) Password associated with the username.
     * host           => (string) What host to connect to, defaults to localhost
     *
     * Some options are used on a case-by-case basis by adapters:
     *
     * port           => (string) The port of the database
     * persistent     => (boolean) Whether to use a persistent connection or not, defaults to false
     * protocol       => (string) The network protocol, defaults to TCPIP
     * caseFolding    => (int) style of case-alteration used for identifiers
     *
     * @param  array|Zend_Config $config An array or instance of Zend_Config having configuration data
     * @throws Zend_Db_Adapter_Exception
     */
    public function __construct($config)
    {
        /*
         * Verify that adapter parameters are in an array.
         */
        if (!is_array($config)) {
            /*
             * Convert Zend_Config argument to a plain array.
             */
            if ($config instanceof Zend_Config) {
                $config = $config->toArray();
            } else {
                /**
                 * @see EPIC_Webservice_Exception
                 */
                throw new EPIC_Webservice_Exception('Adapter parameters must be in an array or a Zend_Config object');
            }
        }
        
        $this->_checkRequiredOptions($config);

        $options = array();

        /*
         * normalize the config and merge it with the defaults
         */
        if (array_key_exists('options', $config)) {
            // can't use array_merge() because keys might be integers
            foreach ((array) $config['options'] as $key => $value) {
                $options[$key] = $value;
            }
        }

        $this->_config = array_merge($this->_config, $config);
        $this->_config['options'] = $options;
    }
    
    /**
     * Check for config options that are mandatory.
     * Throw exceptions if any are missing.
     *
     * @param array $config
     * @throws Zend_Db_Adapter_Exception
     */
    protected function _checkRequiredOptions(array $config)
    {
        // we need at least a dbname
//        if (! array_key_exists('url', $config)) {
//            /** @see EPIC_Webservice_Adapter_Exception */
//            exit();
//            throw new EPIC_Webservice_Adapter_Exception("Configuration array must have a key for 'url' that names the web service location");
//        }
    }
    
    public function connect()
    {
    }

    public function method($method)
    {
    }
}