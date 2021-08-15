<?php

class Blogger_Model_BlogMapper extends EPIC_Model_DataMapper_Abstract
{
    protected $_serviceApiClass = 'Blogger_Model_ServiceApi_Blog';

    public function find($id, Blogger_Model_Blog $blog)
    {   
        $result = $this->getServiceApi()->find($id);

        if (0 == count($result)) {
            return;
        }

        $row = $result[0]; // ->current();

//        tag:blogger.com,1999:blog-1020538993066458697
        $blogId = substr(strrchr((string) $row->id, '-'), 1);
        
        $blog->setId($blogId)
//             ->setAuthorName((string) $row->authorName)
             ->setTitle((string) $row->title)
             ->setUpdated((string) $row->updated);
    }
}
