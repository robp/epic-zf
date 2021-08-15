<?php

class PhotosController extends Zend_Controller_Action
{
    protected $_collectionId  = '757490-72157621821611955';
    protected $_photosPerPage = 4;
    protected $_collection;
    protected $_photosets;
    
    public function init()
    {
        /* Initialize action controller here */
        $this->_collection = new Flickr_Model_Collection();
        $this->_collection->find($this->_collectionId);
        $this->_photosets = $this->_collection->getPhotosets();
    }
    
    protected function _getSetByTitle($title)
    {
        foreach ($this->_photosets as $set) {
            $cleanTitle = $this->view->cleanUrl($set->getTitle());
            if ($cleanTitle == $title) {
                return $set;
            }
        }
        
        return NULL;
    }

    public function indexAction()
    {
        $sets = array();
        
        foreach ($this->_photosets as $set) {
            $_set = array();
            $_set['set'] = $set;

            $photo = new Flickr_Model_Photo();
            $photo->find($set->getPrimary());
            $_set['photo'] = $photo;

            $sets[] = $_set;
        }
        
        $this->view->sets = $sets;
    }

    public function setAction()
    {
        $set   = $this->_getSetByTitle($this->_getParam('title'));
        $pages = ceil($set->getPhotos() / $this->_photosPerPage);
        $page  = (int) $this->_getParam('page', 1);
        
        $photoFinder = new Flickr_Model_Photo();
        $photos = $photoFinder->findByPhotosetId($set->getId(), array(
            'per_page' => $this->_photosPerPage,
            'page' => $page,
        ));
        
        $this->view->set = $set;
        $this->view->photos = $photos;
        $this->view->page = $page;
        $this->view->pages = $pages;
    }

    public function photoAction()
    {
        $prevPhoto = NULL;
        $nextPhoto = NULL;

        $set = $this->_getSetByTitle($this->_getParam('set'));
        
        $photoFinder = new Flickr_Model_Photo();
        $photos = $photoFinder->findByPhotosetId($set->getId());
        
        $pages = count($photos);
        $page = 1;
        
        foreach ($photos as $photo) {
            $cleanTitle = $this->view->cleanUrl($photo->getTitle());
            if ($cleanTitle == $this->_getParam('title')) {
                if ($page < count($photos)) {
                    $nextPhoto = $photos[$page];
                }
                break;
            }
            $page++;
            $prevPhoto = $photo;
        }
        
        $setPage = ceil($page / $this->_photosPerPage);
        
        $this->view->set = $set;
        $this->view->photo = $photo;
        $this->view->prevPhoto = $prevPhoto;
        $this->view->nextPhoto = $nextPhoto;
        $this->view->page = $page;
        $this->view->pages = $pages;
        $this->view->setPage = $setPage;
    }
}
