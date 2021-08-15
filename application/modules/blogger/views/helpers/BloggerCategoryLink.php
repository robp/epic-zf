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
class Blogger_View_Helper_BloggerCategoryLink extends Zend_View_Helper_Abstract
{
    /**
     * Create a link to a blog category.
     *
     * @param string  $category     The string to clean up.
     */

    public function bloggerCategoryLink($category)
    {
        $url = $this->view->url(array(
        	'term' => $category->term
//        ), 'updatesCategory', TRUE);
        ), 'default', TRUE);
        return '<a href="' . $url . '" title="View \'' . $this->view->escape($category->term) . '\' entries">' . $this->view->escape($category->term) . '</a>';
    }
}
