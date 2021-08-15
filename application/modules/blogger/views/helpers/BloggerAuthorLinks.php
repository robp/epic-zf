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
class Blogger_View_Helper_BloggerAuthorLinks extends Zend_View_Helper_Abstract
{
    /**
     * Create a link to a blog entry author.
     *
     * @param string  $str     The string to clean up.
     */
    public function bloggerAuthorLinks($seperator, $authors)
    {
        $result = array_map(array($this, '_authorLink'), $authors);
       	return join($seperator, $result);
    }

    private function _authorLink($author)
    {
        return '<a href="' . $author->uri . '" title="' . $this->view->escape($author->name) . '\'s profile">' . $this->view->escape($author->name) . '</a>';
    }
}
