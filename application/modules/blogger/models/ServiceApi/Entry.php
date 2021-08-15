<?php

class Blogger_Model_ServiceApi_Entry extends EPIC_Model_ServiceApi_Abstract 
{
    protected $_adapterClass = 'EPIC_Webservice_Adapter_Gdata';

//    public function find($options)
//    {
//        // Get the blog entry by id.
//        $query = new Zend_Gdata_Query('http://www.blogger.com/feeds/' . $options['blog-id'] . '/posts/default/' . $options['id']);
//        $result = $this->getAdapter()->method('getEntry', $query);
//        return array($result);        
//    }
    
    public function findByBlogId($blogId, $options = array())
    {
        // Get the blog by id.
        $query = new Zend_Gdata_Query('http://www.blogger.com/feeds/' . $blogId . '/posts/default');
        $query->setParam('max-results', 99999);

        foreach ($options as $key => $val)
        {
            switch ($key)
            {
                case 'categories':
                    if (is_string($val)) {
                        $query->setCategory($val);
                    } elseif (is_array($val)) {
                        foreach ($val as $category) {
                            $query->setCategory($category);
                        }
                    }
                    break;
                case 'max-results':
                case 'published-min':
                case 'published-max':
                case 'start-index':
                    $query->setParam($key, $val);
                    break;
                default:
                    throw new EPIC_Model_ServiceApi_Exception('Invalid option \'' . $key . '\'');
                    break;
            }
        }
        
//        Zend_Debug::dump($query->getQueryUrl());
        $result = $this->getAdapter()->method('getFeed', $query);
        return array($result);
    }
}
