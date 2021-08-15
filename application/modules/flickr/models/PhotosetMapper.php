<?php

class Flickr_Model_PhotosetMapper extends EPIC_Model_DataMapper_Abstract
{
    protected $_serviceApiClass = 'Flickr_Model_ServiceApi_Photoset';

    public function find($id, Flickr_Model_Photoset $photoset)
    {   
        $result = $this->getServiceApi()->find($id);

        if (0 == count($result)) {
            return;
        }

        $row = $result[0]; // ->current();
//        Zend_Debug::dump($row);
        
        $photoset->setId((string) $row['id'])
                 ->setOwner((string) $row['owner'])
                 ->setPrimary((string) $row['primary'])
                 ->setSecret((string) $row['secret'])
                 ->setServer((string) $row['server'])
                 ->setFarm((string) $row['farm'])
                 ->setPhotos((string) $row['photos'])
                 ->setTitle((string) $row->title)
                 ->setDescription((string) $row->description);
    }
}
