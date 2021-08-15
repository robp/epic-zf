<?php

class Blogger_Model_Category extends EPIC_Model_Abstract
{
    protected $_term;
    
    public function setTerm($term)
    {
        $this->_term = $term;
        return $this;
    }

    public function getTerm()
    {
        return $this->_term;
    }
}
