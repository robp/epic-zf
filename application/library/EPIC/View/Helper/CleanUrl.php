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
class EPIC_View_Helper_CleanUrl extends Zend_View_Helper_Abstract
{
    /**
     * Create a clean URL path from a string.
     *
     * @param string  $str     The string to clean up.
     */
    public static function cleanUrl($str)
    {
        $result = $str;

        // convert ampersands into the word "and"
        if (strpos($result, '&amp;') !== false)
            $result = str_replace('&amp;', 'And', $result);
        if (strpos($result, '& ') !== false)
            $result = str_replace('& ', 'And ', $result);

        // convert special characters into close equivalents
        if (strpos($result, '�') !== false)
            $result = str_replace('�', 'C', $result);
        if (preg_match('/[���]/', $result))
            $result = preg_replace('/[���]/', 'u', $result);
        if (preg_match('/[����]/', $result))
            $result = preg_replace('[����]', 'e', $result);
        if (preg_match('/[����]/', $result))
            $result = preg_replace('[����]', 'a', $result);
        if (strpos($result, '�') !== false)
            $result = str_replace('�', 'c', $result);
        if (preg_match('/[���]/', $result))
            $result = preg_replace('[���]', 'i', $result);
        if (preg_match('/[��]/', $result))
            $result = preg_replace('[��]', 'A', $result);
        if (strpos($result, '�') !== false)
            $result = str_replace('�', 'E', $result);
        if (strpos($result, '�') !== false)
            $result = str_replace('�', 'ae', $result);
        if (strpos($result, '�') !== false)
            $result = str_replace('�', 'Ae', $result);
        if (preg_match('/[���]/', $result))
            $result = preg_replace('[���]', 'o', $result);
        if (strpos($result, '�') !== false)
            $result = str_replace('�', 'y', $result);
        if (strpos($result, '�') !== false)
            $result = str_replace('�', 'O', $result);
        if (strpos($result, '�') !== false)
            $result = str_replace('�', 'U', $result);

        // convert whitespace to hyphens
        if (preg_match('/\s/', $result))
            $result = preg_replace('/\s/', '-', $result);

        // remove multiple sequential hyphens
        if (strpos($result, '--') !== false)
        		$result = preg_replace('/\-\-+/', '-', $result);

        // remove leading and trailing hyphens
       	$result = preg_replace('/^\-/', '', $result);
       	$result = preg_replace('/\-$/', '', $result);
       	
       	// remove any non-alphanumeric or hyphen characters and convert to lower case
       	$result = strToLower(preg_replace('/[^a-zA-Z0-9\-]*/', '', $result));
       	
       	return $result;
    }
}