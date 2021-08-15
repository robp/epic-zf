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
class Blogger_View_Helper_BloggerPermalink extends Zend_View_Helper_Abstract
{
    /**
     * Create a link to a blog entry author.
     *
     * @param string  $str     The string to clean up.
     */
    public function bloggerPermalink(Blogger_Model_Entry $entry)
    {
        $pathinfo = pathinfo($entry->getLink('alternate')->getHref());
        return $this->view->bloggerDateLink(
            $entry->getPublished()->get(Zend_Date::YEAR),
            $entry->getPublished()->get(Zend_Date::MONTH),
            $pathinfo['filename']
        );
    }
}
