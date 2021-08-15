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
class EPIC_View_Helper_TrimToWords extends Zend_View_Helper_Abstract
{
    /**
     * Create a link to a blog entry author.
     *
     * @param string  $str     The string to clean up.
     */
    public function trimToWords($text, $numWords, $append = '...')
    {
        $textArray = explode(' ', $text);
        if (count($textArray) > $numWords) {
            return join(' ', array_slice($textArray, 0, $numWords)) . $append;
        }
        return $text;
    }
}
