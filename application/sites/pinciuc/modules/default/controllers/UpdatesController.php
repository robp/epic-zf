<?php

class UpdatesController extends Zend_Controller_Action
{
    protected $_blogId  = '1020538993066458697';
    protected $_entriesPerPage = 10;
    protected $_blog;

    public function init()
    {
        parent::init();
        /* Initialize action controller here */
        $this->_blog = new Blogger_Model_Blog();
        $this->_blog->find($this->_blogId);
        /* @var $router Zend_Controller_Router_Rewrite */
    }

    public function indexAction()
    {
        // action body
        $entryFinder = new Blogger_Model_Entry();
        $entries = $entryFinder->findByBlogId($this->_blogId);
        
        $pages = (int) ceil(count($entries) / $this->_entriesPerPage);
        $page  = (int) $this->_getParam('page', 1);
        $start = ($page - 1) * $this->_entriesPerPage;
        
        $entries = array_slice($entries, $start, $this->_entriesPerPage);
        
        $this->view->entries = $entries;
        $this->view->pages = $pages;
        $this->view->page = $page;
    }

    public function categoryAction()
    {
        // action body
        $entries = array();
        
        // Filter and validate our input
        $filters = array(
            'term' => 'Alnum',
        );
        $validators = array(
            'term' => array(
                'presence' => 'required',
                'NotEmpty',
            ),
        );

        $input = new Zend_Filter_Input($filters, $validators, $this->getRequest()->getParams());

        if ($input->isValid()) {
            $category = new Blogger_Model_Category();
            $category->setTerm($input->term);

            $entryFinder = new Blogger_Model_Entry();
            $entries = $entryFinder->findByBlogId($this->_blogId, array('categories' => $category->term));

            $pages = (int) ceil(count($entries) / $this->_entriesPerPage);
            $page  = (int) $this->_getParam('page', 1);
            $start = ($page - 1) * $this->_entriesPerPage;
            
            $entries = array_slice($entries, $start, $this->_entriesPerPage);
            
            $this->view->entries = $entries;
            $this->view->category = $category;
            $this->view->pages = $pages;
            $this->view->page = $page;
        } else {
            throw new Zend_Controller_Action_Exception("Invalid input data."); //join('<br/>', $input->getMessages()));
        }
        
        $message = new EPIC_Model_Message();
        $message->setType(EPIC_Model_Message::TYPE_INFO)
                ->setText('Showing entries in category "' . $category->getTerm() . '".');
        $this->_messages[] = $message;

        $this->view->messages = $this->_messages;
    }

    public function dateAction()
    {
        // action body
        $entries = array();
        
        // Filter and validate our input
        $filters = array(
            'year' => 'Digits',
            'month' => 'Digits',
            'day' => 'Digits',
            'title' => 'StripTags',
            'page' => 'Digits',
        );
        $validators = array(
            'year' => array(
            	'presence' => 'required'
            ),
            'month' => array(
                array('StringLength', 2, 2)
            ),
            'day' => array(
                array('StringLength', 2, 2)
            ),
            'title' => 'NotEmpty',
            'page' => array(
                array('GreaterThan', 0)
            ),
        );

        if ($this->_hasParam('title')) {
            // A title being present requires a month being present.
            $validators['month']['presence'] = 'required'; 
            $validators['day']['default'] = '01';
        } elseif ($this->_hasParam('day')) {
            // A day being present requires a month being present.
            $validators['month']['presence'] = 'required'; 
        } else {
            $validators['day']['default'] = '01';
            $validators['month']['default'] = '01';
        }
        
        $input = new Zend_Filter_Input($filters, $validators, $this->_getAllParams());

        if ($input->isValid()) {
            $dateStr = "{$input->year}-{$input->month}-{$input->day}";
            
            //Make sure it's a valid date (e.g., 2000-02-30 will fail).
            if (Zend_Validate::is($dateStr, 'Date')) {
                $dateFormat = 'yyyy-MM-dd';
                $fromDate = new Zend_Date($dateStr, $dateFormat);

                // Make sure $fromDate <= today.
                if ($fromDate->isEarlier(new Zend_Date(), $dateFormat)) {
                    $toDate = new Zend_Date($dateStr, $dateFormat);
                    $message = new EPIC_Model_Message();
                    $message->setType(EPIC_Model_Message::TYPE_INFO);
                    
                    // Define $toDate based on URL parameters present.
                    if ($this->_hasParam('title')) {
                        $toDate->add(1, Zend_Date::MONTH);
                    }
                    else {
                        if ($this->_hasParam('day')) {
                            $toDate->add(1, Zend_Date::DAY);
                            $dateText = $fromDate->get(Zend_Date::DATE_LONG);
                        } elseif ($this->_hasParam('month')) {
                            $toDate->add(1, Zend_Date::MONTH);
                            $dateText = $fromDate->get(Zend_Date::MONTH_NAME . ' ' . Zend_Date::YEAR);
                        } else {
                            $toDate->add(1, Zend_Date::YEAR);
                            $dateText = $fromDate->get(Zend_Date::YEAR);
                        }
                        $message->setText("Showing entries for $dateText.");
                    }
                    
                    $entryFinder = new Blogger_Model_Entry();
                    $entries = $entryFinder->findByBlogId($this->_blogId, array(
                    	'published-min' => $fromDate->get($dateFormat),
                        'published-max' => $toDate->get($dateFormat)
                    ));

                    if (isset($input->title)) {
                        foreach ($entries as $entry) {
                            $pathinfo = pathinfo($entry->getLink('alternate')->getHref());
                            if ($pathinfo['filename'] == $input->title) {
                                $entries = array($entry);
                                break;
                            }
                        }
                    } else {
                        $pages = (int) ceil(count($entries) / $this->_entriesPerPage);
                        $page  = (int) $this->_getParam('page', 1);
                        $start = ($page - 1) * $this->_entriesPerPage;
                
                        $entries = array_slice($entries, $start, $this->_entriesPerPage);
                        $this->_messages[] = $message;
                        
                        $this->view->messages = $this->_messages;
                        $this->view->pages = $pages;
                        $this->view->page = $page;
                    }

                    if (isset($dateText)) {
                        $this->view->dateText = $dateText;
                    }

                    $this->view->entries = $entries;
                } else {
                    throw new Zend_Controller_Action_Exception("Specified date is in the future.");
                }
            }
        } else {
            throw new Zend_Controller_Action_Exception("Invalid input data."); //join('<br/>', $input->getMessages()));
        }

//        $router = $this->getFrontController()->getRouter();
//        Zend_Debug::dump($router->getCurrentRouteName());
//        Zend_Debug::dump($router->getCurrentRoute()->assemble());
//        Zend_Debug::dump($this->getRequest()->getParams());
//        Zend_Debug::dump($input);
    }
    
    public function archiveAction()
    {
        $archive = $this->_blog->getArchive();
        $this->view->archive = $archive;
        if ($this->_hasParam('entry') && $this->_getParam('entry') instanceof Blogger_Model_Entry) {
            $this->view->entry = $this->_getParam('entry');
        }
    }
    
    public function categoriesAction()
    {
        $categories = $this->_blog->getCategories();
//        Zend_Debug::dump($categories);
        $this->view->categories = $categories;
        if ($this->_hasParam('entry') && $this->_getParam('entry') instanceof Blogger_Model_Entry) {
            $this->view->entry = $this->_getParam('entry');
        }
    }
}
