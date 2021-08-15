<?php

class Blogger_Model_EntryMapper extends EPIC_Model_DataMapper_Abstract
{
    protected $_serviceApiClass = 'Blogger_Model_ServiceApi_Entry';

    private function _createEntriesFromRows($rows)
    {
        $entries = array();
        
        foreach ($rows as $row) {
            $entryId = substr(strrchr((string) $row->id, '-'), 1);
            $entry = new Blogger_Model_Entry();
            $entry->setId($entryId)
                  ->setTitle((string) $row->title)
                  ->setContent((string) $row->content)
                  ->setUpdated((string) $row->updated);
            $published = new Zend_Date((string) $row->published, 'yyyy-MM-ddTHH:mm:ss.SZ');
            $entry->setPublished($published);
            $authors = array();
            foreach ($row->author as $a) {
                $author = new Blogger_Model_Author();
                $author->setName((string) $a->name)
                       ->setEmail((string) $a->email)
                       ->setUri((string) $a->uri);
                $authors[] = $author;
            }
            $entry->setAuthors($authors);
            $categories = array();
            foreach ($row->category as $c) {
                $category = new Blogger_Model_Category();
                $category->setTerm($c->term);
                $categories[] = $category;
            }
            $entry->setCategories($categories);
            $links = array();
            foreach ($row->link as $l) {
                $link = new Blogger_Model_Link();
                $link->setRel($l->rel)
                     ->setHref($l->href)
                     ->setType($l->type)
                     ->setTitle($l->title);
                $links[] = $link;
            }
            $entry->setLinks($links);
            $entries[] = $entry;
        }
        
        return $entries;
    }
    
//    public function find($id, Blogger_Model_Entry $entry)
//    {   
//        $result = $this->getServiceApi()->find($id);
//
//        if (0 == count($result)) {
//            return;
//        }
//
//        $row = $result[0]; // ->current();
//        
//        $entry = new Blogger_Model_Entry();
//        $entry->setId((string) $row->id)
//              ->setTitle((string) $row->title)
//              ->setUpdated((string) $row->updated);
//    }

    public function findByBlogId($blogId, $options = array())
    {
        $result = $this->getServiceApi()->findByBlogId($blogId, $options);
        
        if (0 == count($result)) {
            return;
        }
        
        $row = $result[0];
        $entries = $this->_createEntriesFromRows($row->entry);
        return $entries;
    }
}
