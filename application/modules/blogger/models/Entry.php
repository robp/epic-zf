<?php

class Blogger_Model_Entry extends EPIC_Model_Abstract
{
    protected $_id;
    protected $_authors;
    protected $_title;
    protected $_published;
    protected $_updated;
    protected $_content;
    protected $_categories;
    protected $_links;
    
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setAuthors($authors)
    {
        $this->_authors = $authors;
        return $this;
    }

    public function getAuthors()
    {
        return $this->_authors;
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
    
    public function setPublished($published)
    {
        $this->_published = $published;
        return $this;
    }

    public function getPublished()
    {
        return $this->_published;
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

    public function setContent($content)
    {
        $this->_content = $content;
        return $this;
    }

    public function getContent()
    {
        return $this->_content;
    }

    public function setCategories($categories)
    {
        $this->_categories = $categories;
        return $this;
    }

    public function getCategories()
    {
        return $this->_categories;
    }

    public function setLinks($links)
    {
        $this->_links = $links;
        return $this;
    }

    public function getLinks()
    {
        return $this->_links;
    }
    
    public function getLink($rel, $type = NULL)
    {
        foreach ($this->getLinks() as $link) {
            if ($rel == $link->getRel()) {
                if (!isset($type)) {
                    return $link;
                } elseif ($link->getType() == $type) {
                    return $link;
                }
            }
        }
        return NULL;
    }
    
    public function findByBlogId($blogId, $options = array())
    {
        return $this->getMapper()->findByBlogId($blogId, $options);
    }
}