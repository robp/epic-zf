<?php

abstract class EPIC_Model_DataMapper_Abstract
{
    protected $_serviceApiClass;
    protected $_dbTableClass;
        
    protected $_dbTable;
    protected $_serviceApi;
    
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable($this->_dbTableClass);
        }
        return $this->_dbTable;
    }

    public function setServiceApi($serviceApi)
    {
        if (is_string($serviceApi)) {
            $serviceApi = new $serviceApi();
        }
        if (!$serviceApi instanceof EPIC_Webservice_Api_Abstract) {
            throw new Exception('Invalid Service API gateway provided');
        }
        $this->_serviceApi = $serviceApi;
        return $this;
    }

    public function getServiceApi()
    {
        if (null === $this->_serviceApi) {
            $this->setServiceApi($this->_serviceApiClass);
        }
        return $this->_serviceApi;
    }
    
    public function save(EPIC_Model_Abstract $model)
    {
        /*
        $data = array(
            'email'   => $guestbook->getEmail(),
            'comment' => $guestbook->getComment(),
            'created' => date('Y-m-d H:i:s'),
        );

        if (null === ($id = $guestbook->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
*/
    }

    public function find($id, EPIC_Model_Abstract $model)
    {
        /*
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $guestbook->setId($row->id)
                  ->setEmail($row->email)
                  ->setComment($row->comment)
                  ->setCreated($row->created);
*/
    }

    public function fetchAll()
    {
        /*
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Default_Model_Guestbook();
            $entry->setId($row->id)
                  ->setEmail($row->email)
                  ->setComment($row->comment)
                  ->setCreated($row->created)
                  ->setMapper($this);
            $entries[] = $entry;
        }
        return $entries;
*/
    }
}
