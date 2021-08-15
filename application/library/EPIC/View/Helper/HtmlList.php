<?php

/**
 * Helper for ordered and unordered lists
 *
 * @uses Zend_View_Helper_HtmlList
 * @category   Pinciuc
 * @package    Pinciuc_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2009 Rob Pinciuc (http://www.pinciuc.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class EPIC_View_Helper_HtmlList extends Zend_View_Helper_HtmlList
{
    /**
     * Override default htmlList() view helper to add extra classes to li elements. 
     *
     * @param array   $items   Array with the elements of the list
     * @param boolean $ordered Specifies ordered/unordered list; default unordered
     * @param array   $attribs Attributes for the ol/ul tag.
     * @return string The list XHTML.
     */
    public function htmlList(array $items, $ordered = false, $attribs = false, $escape = true)
    {
        if (!is_array($items)) {
            require_once 'Zend/View/Exception.php';
            throw new Zend_View_Exception('First param must be an array', $this);
        }

        $list = '';

        $count = 0;
        
        foreach ($items as $item) {
            $liClasses = array();
            $liAttribs = array();
            
            $liClasses[] = 'item-' . ($count+1);
            
            $liClasses[] = $count % 2 ? 'even' : 'odd';

            if ($count == 0) {
                $liClasses[] = 'first';
            }
            if ($count == count($items)-1) {
                $liClasses[] = 'last';
            }
            
            if ($liClasses) {
                $liAttribs[] = 'class="'.join(' ', $liClasses).'"';
            }
            
            if (!is_array($item)) {
                if ($escape) {
                    $item = $this->view->escape($item);
                }
                $list .= '<li'.($liAttribs ? ' '.join(' ', $liAttribs) : '').'>' . $item . '</li>' . self::EOL;
            } else {
                if (6 < strlen($list)) {
                    $list = substr($list, 0, strlen($list) - 6)
                     . $this->htmlList($item, $ordered, $attribs, $escape) . '</li>' . self::EOL;
                } else {
                    $list .= '<li'.($liAttribs ? ' '.join(' ', $liAttribs) : '').'>' . $this->htmlList($item, $ordered, $attribs, $escape) . '</li>' . self::EOL;
                }
            }
            
            $count++;
        }

        if ($attribs) {
            $attribs = $this->_htmlAttribs($attribs);
        } else {
            $attribs = '';
        }

        $tag = 'ul';
        if ($ordered) {
            $tag = 'ol';
        }

        return '<' . $tag . $attribs . '>' . self::EOL . $list . '</' . $tag . '>' . self::EOL;
    }
}