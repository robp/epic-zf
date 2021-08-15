<?php

/**
 * Helper for pagination.
 *
 * @uses Zend_View_Helper_Abstract
 * @category   Pinciuc
 * @package    Pinciuc_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2009 Rob Pinciuc (http://www.pinciuc.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Default_View_Helper_Pager extends Zend_View_Helper_Abstract
{
    /**
     * Create an unordered list of page navigation links, including Previous and Next links. 
     *
     * @param array   $items   Array with the elements of the list
     * @param boolean $ordered Specifies ordered/unordered list; default unordered
     * @param array   $attribs Attributes for the ol/ul tag.
     * @return string The list XHTML.
     */
    public function pager($page = 1, $pages, $prevUrl = NULL, $nextUrl = NULL)
    {
        if (!is_int($page)) {
            require_once 'Zend/View/Exception.php';
            throw new Zend_View_Exception('$page must be an integer', $this->view);
        }
        if (!is_int($pages)) {
            require_once 'Zend/View/Exception.php';
            throw new Zend_View_Exception('$pages must be an integer', $this->view);
        }
        if ($page < 1) {
            require_once 'Zend/View/Exception.php';
            throw new Zend_View_Exception('$page must be greater than zero', $this->view);
        }
        if ($page > $pages) {
            require_once 'Zend/View/Exception.php';
            throw new Zend_View_Exception('$page is greater than $pages', $this->view);
        }
        
        $request = Zend_Controller_Front::getInstance()->getRequest();
        
        $items = array();

        if ($page > 1) {
            if ($prevUrl === NULL) {
                $params = array(); //$request->getParams();
                if ($page-1 == 1) {
                    $params['page'] = NULL;
                }
                else {
                    $params['page'] = $page-1;
                }
                $url = $this->view->url($params);
            }
            else {
                $url = $prevUrl;
            }
            $items[] = '<a href="'.$url.'">Previous</a>';
        }
        else {
            $items[] = 'Previous';
        }

        $items[] = "$page of $pages";

        if ($page < $pages) {
            if ($nextUrl === NULL) {
                $params = array(); //$request->getParams();
                $params['page'] = $page+1;
                $url = $this->view->url($params);
            }
            else {
                $url = $nextUrl;
            }
            $items[] = '<a href="'.$url.'">Next</a>';
        }
        else {
            $items[] = 'Next';
        }
                
        return $this->view->htmlList($items, false, array('class' => 'pager'), false);
    }
}