<?php

abstract class EPIC_Model_Abstract
{
    protected $_mapperClass;
    protected $_mapper;
    
    public function __construct($options = NULL)
    {
        $this->setMapperClass(get_class($this) . 'Mapper');
        
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid ' . get_class($this) . ' property \'' . $name . '\'');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid ' . get_class($this) . ' property \'' . $name . '\'');
        }
        return $this->$method();
    }

    public function setOptions($options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function setMapperClass($mapperClass)
    {
        $this->_mapperClass = $mapperClass;
        return $this;
    }

    public function getMapperClass()
    {
        return $this->_mapperClass;
    }
    
    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    public function getMapper()
    {
        if (NULL === $this->_mapper) {
            $this->setMapper(new $this->_mapperClass());
        }
        return $this->_mapper;
    }

    public function save()
    {
        $this->getMapper()->save($this);
    }

    public function find($id)
    {
        $this->getMapper()->find($id, $this);
        return $this;
    }

    public function fetchAll()
    {
        return $this->getMapper()->fetchAll();
    }
}
