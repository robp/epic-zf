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
class Node_View_Helper_Permalink extends Zend_View_Helper_Abstract
{
    /**
     * Create a link to a blog entry author.
     *
     * @param string  $str     The string to clean up.
     */
    public function permalink($node)
    {
        $url = $node->getUrl(); 
//        $this->view->url(array('action' => 'slug', 'controller' => 'index', 'module' => 'node', 'slug' => $node->slug, 'id' => $node->id), 'nodeViewSlug', TRUE);
        return $url;
    }
}
