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
class Blogger_View_Helper_BloggerEntryCount extends Zend_View_Helper_Abstract
{
    /**
     * Create a link to a blog entry author.
     *
     * @param string  $str     The string to clean up.
     */
    public function bloggerEntryCount(array $items)
    {
        $count = 0;
        foreach ($items as $item) {
            if (is_array($item)) {
                $count += $this->bloggerEntryCount($item);
            } else {
                $count++;
            }
        }
        return $count;
    }
}
