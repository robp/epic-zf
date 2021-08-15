<?php

class Blogger_Model_Blog extends EPIC_Model_Abstract
{
    protected $_id;
    protected $_authorName;
    protected $_title;
    protected $_updated;
    
    protected $_entries;

    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setAuthorName($authorName)
    {
        $this->_authorName = $authorName;
        return $this;
    }

    public function getAuthorName()
    {
        return $this->_authorName;
    }

    public function setTitle($title)
    {
        $this->_title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function setUpdated($updated)
    {
        $this->_updated = $updated;
        return $this;
    }

    public function getUpdated()
    {
        return $this->_updated;
    }
    
    public function setEntries($entries)
    {
        $this->_entries = $entries;
        return $this;
    }

    public function getEntries()
    {
        return $this->_entries;
    }
    
    public function getArchive()
    {
        $entryFinder = new Blogger_Model_Entry();
        $entries = $entryFinder->findByBlogId($this->getId());
        $archive = array();
        
        foreach ($entries as $entry) {
            $archive[$entry->getPublished()->get(Zend_Date::YEAR)][$entry->getPublished()->get(Zend_Date::MONTH)][] = $entry;
        }
        
        return $archive;
    }

    public function getCategories()
    {
        $entryFinder = new Blogger_Model_Entry();
        $entries = $entryFinder->findByBlogId($this->getId());
        $categories = array();
        
        foreach ($entries as $entry) {
            foreach ($entry->getCategories() as $category) {
                $term = $category->getTerm();
                if (!isset($categories[$term])) {
                    $categories[$term]['category'] = $category;
                }
                $categories[$term]['entries'][] = $entry;
            }
        }
        
        return $categories;
    }
}