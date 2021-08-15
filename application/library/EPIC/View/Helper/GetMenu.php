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
class EPIC_View_Helper_GetMenu extends Zend_View_Helper_Abstract
{
    /**
     * Create a clean URL path from a string.
     *
     * @param string  $str     The string to clean up.
     */
    public static function getMenu($name)
    {
        $menu = Doctrine_Core::getTable('Menu_Model_Menu')->findOneByName($name);
      	return $menu;
    }
}