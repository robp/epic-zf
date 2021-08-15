<?php

/**
 * Helper to create clean URL paths.
 *
 * @uses Zend_View_Helper_Abstract
 * @category   Pinciuc
 * @package    Pinciuc_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2009 Rob Pinciuc (http://www.pinciuc.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Blogger_View_Helper_BloggerDateLink extends Zend_View_Helper_Abstract
{
    /**
     * Create a link to a blog entry author.
     *
     * @param string  $str     The string to clean up.
     */
    public function bloggerDateLink($year, $month = NULL, $title = NULL)
    {
//        $router = Zend_Controller_Front::getInstance()->getRouter();
//        Zend_Debug::dump($router->getCurrentRouteName());
        $routeName = 'updatesYear';
        if ($title && $month) {
            $routeName = 'updatesDate';
        } elseif ($month) {
            $routeName = 'updatesMonth';
        }

        $routeName = 'default';
        
        $url = $this->view->url(array(
        	'year' => $year, 
        	'month' => $month, 
            'title' => $title
        ), $routeName, TRUE); 
        return $url;
    }
}
