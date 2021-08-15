<?php

class EPIC_Filter_Tags implements Zend_Filter_Interface
{
    protected $_separator = ',';
    
    public function __construct(array $options = array()) {
        foreach ($options as $option => $val) {
            switch ($option) {
                case 'separator':
                    $this->setSeparator($val);
                    break;
            }
        }
    }
    
    public function filter($value)
    {
        $tags = $value;

        if (!is_array($tags)) {
            $tags = explode(',', $tags);
        }
        
        $filteredTags = array();
        $filterChain = new Zend_Filter();
        $filterChain->addFilter(new Zend_Filter_StripTags())
                    ->addFilter(new Zend_Filter_StringTrim());
        
        foreach ($tags as $tag) {
            $filteredTag = $filterChain->filter($tag);
            
            if (strlen($tag)) {
                $filteredTags[] = $filteredTag;
            }
        }
        
        $valueFiltered = implode($this->getSeparator(), $filteredTags);
        return $valueFiltered;
    }
    
    public function setSeparator($separator = ',')
    {
        $this->_separator = $separator;
    }
    
    public function getSeparator() {
        return $this->_separator;
    }
}
