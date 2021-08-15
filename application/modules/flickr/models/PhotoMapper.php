<?php

class Flickr_Model_PhotoMapper extends EPIC_Model_DataMapper_Abstract
{
    protected $_serviceApiClass = 'Flickr_Model_ServiceApi_Photo';

    public function find($id, Flickr_Model_Photo $photo)
    {   
        $result = $this->getServiceApi()->find($id);

        if (0 == count($result)) {
            return;
        }

        $row = $result[0]; // ->current();
//        Zend_Debug::dump($row);
        
        $tags = array();
        
        foreach ($row->tags->tag as $t) {
            $tag = new Flickr_Model_Tag();
            $tag->setId((string) $t['id'])
                ->setAuthor((string) $t['author'])
                ->setRaw((string) $t['raw'])
                ->setMachineTag((string) $t['machine_tag'])
                ->setTag((string) $t);
            $tags[] = $tag;
        }

        $photo->setId((string) $row['id'])
              ->setSecret((string) $row['secret'])
              ->setServer((string) $row['server'])
              ->setFarm((string) $row['farm'])
              ->setDateuploaded((string) $row['dateuploaded'])
              ->setIsfavorite((string) $row['isfavorite'])
              ->setLicense((string) $row['license'])
              ->setRotation((string) $row['rotation'])
              ->setViews((string) $row['views'])
              ->setMedia((string) $row['media'])
              ->setTitle((string) $row->title)
              ->setDescription((string) $row->description)
              ->setDatePosted((string) $row->dates['posted'])
              ->setDateTaken((string) $row->dates['taken'])
              ->setDateLastupdate((string) $row->dates['lastupdate'])
              ->setComments((string) $row->comments)
              ->setTags($tags)
              ->setUrl((string) $row->urls->url);
    }

    public function getSizes(Flickr_Model_Photo $photo)
    {
        $result = $this->getServiceApi()->getSizes($photo->getId());
        
        if (0 == count($result)) {
            return;
        }

        $row = $result[0]; // ->current();

        $sizes = array();
        
        foreach ($row->size as $s) {
            $size = new Flickr_Model_Photo_Size();
            $size->setLabel((string) $s['label'])
                 ->setWidth((string) $s['width'])
                 ->setHeight((string) $s['height'])
                 ->setSource((string) $s['source'])
                 ->setUrl((string) $s['url']);
            $sizes[] = $size;
        }
        
        return $sizes;
    }

    public function findByPhotosetId($photosetId, $options = array())
    {
        $result = $this->getServiceApi()->findByPhotosetId($photosetId, $options);
        
        if (0 == count($result)) {
            return;
        }
        
        $row = $result[0];
        
        $photos = array();
        
        foreach ($row->photo as $p) {
            $photo = new Flickr_Model_Photo();
            $photo->find((string) $p['id']);
            $photos[] = $photo;
        }

        return $photos;
    }
}
