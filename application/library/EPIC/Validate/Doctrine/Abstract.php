<?php

abstract class EPIC_Validate_Doctrine_Abstract extends Zend_Validate_Abstract
{
	/**
     * Error constants
     */
    const ERROR_NO_RECORD_FOUND = 'noRecordFound';
    const ERROR_RECORD_FOUND    = 'recordFound';

    /**
     * @var array Message templates
     */
    protected $_messageTemplates = array(
        self::ERROR_NO_RECORD_FOUND => 'No record matching %value% was found',
        self::ERROR_RECORD_FOUND    => 'A record matching %value% was found',
    );

    /**
     * @var string
     */
    protected $_table = '';

    /**
     * @var string
     */
    protected $_field = '';

    /**
     * @var mixed
     */
    protected $_exclude = null;
    
    /**
     * Provides basic configuration for use with EPIC_Validate_Doctrine Validators
     * Setting $exclude allows a single record to be excluded from matching.
     * Exclude can either be a String containing a where clause, or an array with `field` and `value` keys
     * to define the where clause added to the sql.
     *
     * The following option keys are supported:
     * 'table'   => The database table to validate against
     * 'field'   => The field to check for a match
     * 'exclude' => An optional where clause or field/value pair to exclude from the query
     *
     * @param array|Zend_Config $options Options to use for this validator
     */
    public function __construct($options)
    {
        if ($options instanceof Zend_Config) {
            $options = $options->toArray();
        } else if (func_num_args() > 1) {
            $options       = func_get_args();
            $temp['table'] = array_shift($options);
            $temp['field'] = array_shift($options);
            if (!empty($options)) {
                $temp['exclude'] = array_shift($options);
            }

            $options = $temp;
        }

        if (!array_key_exists('table', $options)) {
            require_once 'Zend/Validate/Exception.php';
            throw new Zend_Validate_Exception('Table option missing!');
        }

        if (!array_key_exists('field', $options)) {
            require_once 'Zend/Validate/Exception.php';
            throw new Zend_Validate_Exception('Field option missing!');
        }

        if (array_key_exists('exclude', $options)) {
            $this->setExclude($options['exclude']);
        }

        $this->setField($options['field']);
        if (array_key_exists('table', $options)) {
            $this->setTable($options['table']);
        }
    }    
    /**
     * 
     * Returns the set exclude clause
     *
     * @return string|array
     */
    public function getExclude()
    {
        return $this->_exclude;
    }

    /**
     * Sets a new exclude clause
     *
     * @param string|array $exclude
     * @return EPIC_Validate_Doctrine_Abstract
     */
    public function setExclude($exclude)
    {
        $this->_exclude = $exclude;
        return $this;
    }

    /**
     * Returns the set field
     *
     * @return string|array
     */
    public function getField()
    {
        return $this->_field;
    }

    /**
     * Sets a new field
     *
     * @param string $field
     * @return EPIC_Validate_Doctrine_Abstract
     */
    public function setField($field)
    {
        $this->_field = (string) $field;
        return $this;
    }

    /**
     * Returns the set table
     *
     * @return string
     */
    public function getTable()
    {
        return $this->_table;
    }

    /**
     * Sets a new table
     *
     * @param string $table
     * @return EPIC_Validate_Doctrine_Abstract
     */
    public function setTable($table)
    {
        $this->_table = (string) $table;
        return $this;
    }
    
    /**
     * Run query and returns matches, or null if no matches are found.
     *
     * @param  String $value
     * @return Array
     */
    protected function _query($value)
    {
        /**
         * Check for an adapter being defined. if not, fetch the default adapter.
         */
//        if ($this->_adapter === null) {
//            $this->_adapter = Zend_Db_Table_Abstract::getDefaultAdapter();
//            if (null === $this->_adapter) {
//                require_once 'Zend/Validate/Exception.php';
//                throw new Zend_Validate_Exception('No database adapter present');
//            }
//        }

        /**
         * Build select query
         */
        $q = Doctrine_Query::create()
            ->select($this->_field)
            ->from($this->_table)
            ->where($this->_field . ' = ?', $value);

        if ($this->_exclude !== null) {
            if (is_array($this->_exclude)) {
                $q->andWhere($this->_exclude['field'].' != ?', $this->_exclude['value']);
            } else {
                $q->andWhere($this->_exclude);
            }
        }

        $q->limit(1);

        /**
         * Run query
         */
        $result = $q->execute();
        
        return $result;
    }
}