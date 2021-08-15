<?php

/**
 * Based on abstract class Zend_Db_Table_Abstract.
 */

abstract class EPIC_Webservice_Api_Abstract
{
    const ADAPTER          = 'client';
    
    const DEFAULT_ADAPTER       = 'defaultClient';
    
	/**
     * Default EPIC_Webservice_Adapter_Abstract object.
     *
     * @var EPIC_Webservice_Adapter_Abstract
     */
    protected static $_defaultClient;

    /**
     * EPIC_Webservice_Adapter_Abstract object.
     *
     * @var EPIC_Webservice_Adapter_Abstract
     */
    protected $_client;

    /**
     * Constructor.
     *
     * Supported params for $config are:
     * - db              = user-supplied instance of database connector,
     *                     or key name of registry instance.
     *
     * @param  mixed $config Array of user-specified config options, or just the Db Adapter.
     * @return void
     */
    public function __construct($config = array())
    {
        /**
         * Allow a scalar argument to be the Adapter object or Registry key.
         */
        if (!is_array($config)) {
            $config = array(self::ADAPTER => $config);
        }

        if ($config) {
            $this->setOptions($config);
        }

        $this->_setup();
        $this->init();
    }

    /**
     * setOptions()
     *
     * @param array $options
     * @return Zend_Db_Table_Abstract
     */
    public function setOptions(Array $options)
    {
        foreach ($options as $key => $value) {
            switch ($key) {
                case self::ADAPTER:
                    $this->_setAdapter($value);
                    break;
                default:
                    // ignore unrecognized configuration directive
                    break;
            }
        }

        return $this;
    }

	/**
     * Sets the default EPIC_ServiceApi_Adapter_Abstract for all EPIC_Webservice_Api objects.
     *
     * @param  mixed $db Either an Adapter object, or a string naming a Registry key
     * @return void
     */
    public static function setDefaultAdapter($client = null)
    {
        self::$_defaultClient = self::_setupAdapter($client);
    }

    /**
     * Gets the default EPIC_Webservice_Adapter_Abstract for all EPIC_Webservice_Api objects.
     *
     * @return Zend_Db_Adapter_Abstract or null
     */
    public static function getDefaultAdapter()
    {
        return self::$_defaultClient;
    }

    /**
     * @param  mixed $adapter Either an Adapter object, or a string naming a Registry key
     * @return Zend_Db_Table_Abstract Provides a fluent interface
     */
    protected function _setAdapter($client)
    {
        $this->_client = self::_setupAdapter($client);
        return $this;
    }

    /**
     * Gets the Zend_Db_Adapter_Abstract for this particular Zend_Db_Table object.
     *
     * @return Zend_Db_Adapter_Abstract
     */
    public function getAdapter()
    {
        return $this->_client;
    }

    /**
     * @param  mixed $client Either an Adapter object, or a string naming a Registry key
     * @return Zend_Db_Adapter_Abstract
     * @throws Zend_Db_Table_Exception
     */
    protected static function _setupAdapter($client)
    {
        if ($client === null) {
            return null;
        }
        if (is_string($client)) {
            $client = Zend_Registry::get($client);
        }
        if (!$client instanceof EPIC_Webservice_Adapter_Abstract) {
            throw new EPIC_Webservice_Api_Exception('Argument must be of type EPIC_Webservice_Adapter_Abstract, or a Registry key where a EPIC_Webservice_Adapter_Abstract object is stored');
        }
        return $client;
    }
    
	/**
     * Turnkey for initialization of a web service object.
     * Calls other protected methods for individual tasks, to make it easier
     * for a subclass to override part of the setup logic.
     *
     * @return void
     */
    protected function _setup()
    {
        $this->_setupWebserviceAdapter();
    }

    /**
     * Initialize web service adapter.
     *
     * @return void
     */
    protected function _setupWebserviceAdapter()
    {
        if (! $this->_client) {
            $this->_client = self::getDefaultAdapter();
            if (!$this->_client instanceof EPIC_Webservice_Adapter_Abstract) {
                throw new EPIC_Webservice_Api_Exception('No adapter found for ' . get_class($this));
            }
        }
    }
    
    /**
     * Initialize object
     *
     * Called from {@link __construct()} as final step of object instantiation.
     *
     * @return void
     */
    public function init()
    {
    }
}
