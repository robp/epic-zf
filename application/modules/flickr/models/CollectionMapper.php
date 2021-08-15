<?php

class Flickr_Model_CollectionMapper extends EPIC_Model_DataMapper_Abstract
{
    protected $_serviceApiClass = 'Flickr_Model_ServiceApi_Collection';

    public function find($id, Flickr_Model_Collection $collection)
    {   
        $result = $this->getServiceApi()->find($id);

        if (0 == count($result)) {
            return;
        }

        $row = $result[0]; // ->current();
//        Zend_Debug::dump($row);

        $photosetIds = array();
        
        foreach ($row->set as $photoset) {
            $photosetIds[] = (string) $photoset['id'];
        }
        
        $collection->setId((string) $row['id'])
                   ->setTitle((string) $row['title'])
                   ->setDescription((string) $row['description'])
                   ->setIconlarge((string) $row['iconlarge'])
                   ->setIconsmall((string) $row['iconsmall'])
                   ->setPhotosetIds($photosetIds);
    }

    public function fetchAll()
    {
        $resultSet      = $this->getServiceApi()->fetchAll();
        $collections    = array();
        foreach ($resultSet as $row) {
            $collection = new Flickr_Model_Collection();
            $collection->setId($row->id)
                       ->setTitle($row->title)
                       ->setDescription($row->description)
                       ->setIconlarge($row->iconlarge)
                       ->setIconsmall($row->iconsmall);
            $collections[] = $collection;
        }
        return $collections;
    }
}
