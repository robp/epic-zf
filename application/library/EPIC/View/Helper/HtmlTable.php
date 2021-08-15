<?php

/**
 * Helper for creating a table.
 *
 * @uses Zend_View_Helper_HtmlList
 * @category   Pinciuc
 * @package    Pinciuc_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2009 Rob Pinciuc (http://www.pinciuc.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class EPIC_View_Helper_HtmlTable extends Zend_View_Helper_HtmlElement
{
    /**
     * Override default htmlList() view helper to add extra classes to li elements. 
     *
     * @param array   $items   Array with the elements of the list
     * @param boolean $ordered Specifies ordered/unordered list; default unordered
     * @param array   $attribs Attributes for the ol/ul tag.
     * @return string The list XHTML.
     */
    public function htmlTable(array $headItems, array $bodyItems, $attribs = array(), $escape = true, $sortable = false, $sticky = false)
    {
        if (!is_array($headItems)) {
            require_once 'Zend/View/Exception.php';
            throw new Zend_View_Exception('First param must be an array', $this);
        }
        if (!is_array($bodyItems)) {
            require_once 'Zend/View/Exception.php';
            throw new Zend_View_Exception('Second param must be an array', $this);
        }
        
        $output = '<thead>' . self::EOL;
        $output .= $this->_processRows($headItems, 'th', $escape);
        $output .= '</thead>' . self::EOL;
        
        $output .= '<tbody>' . self::EOL;
        $output .= $this->_processRows($bodyItems, 'td', $escape);
        $output .= '</tbody>';
        
        if ($sortable) {
            $this->_sortableHtml($sortable);
            $attribs['class'] = trim($attribs['class'] . ' tablesorter');
        }

//        if ($sticky) {
//            $this->_stickyHtml();
//            $attribs['class'] = trim($attribs['class'] . ' sticky');
//        }

        $attribs = $this->_htmlAttribs($attribs);
        
        $tag = 'table';

        return '<' . $tag . $attribs . '>' . self::EOL . $output . '</' . $tag . '>' . self::EOL;
    }
    
    private function _processRows($rows, $tdTag = 'td', $escape)
    {
        $output = '';
        $count = 0;

        foreach ($rows as $row) {
            $classes = array();
            $attribs = array();

            if (isset($row['attribs'])) {
                $attribs = $row['attribs'];
                $row = $row['data'];
            }

            $classes[] = 'row-' . ($count+1);
            
            if ($count == 0) {
                $classes[] = 'first';
            }
            if ($count == count($rows)-1) {
                $classes[] = 'last';
            }
            $classes[] = $count % 2 ? 'even' : 'odd';

            if (!empty($attribs['class'])) {
                $classes[] = $attribs['class'];
            }
            
            if ($classes) {
                $attribs['class'] = implode(' ', $classes);
            }
            
            if ($attribs) {
                $attribs = $this->_htmlAttribs($attribs);
            } else {
                $attribs = '';
            }

            $tag = 'tr';
            
            $output .= '<' . $tag . $attribs . '>' . self::EOL;
            $output .= $this->_processRow($row, $tdTag, $escape);
            $output .= '</' . $tag . '>' . self::EOL;
            $count++;
        }
        
        return $output;
    }
    
    private function _processRow($row, $tag = 'td', $escape)
    {
        $output = '';
        $count = 0;
        
        foreach ($row as $item) {
            $classes = array();
            $attribs = array();

            if (is_array($item)) {
                $attribs = $item[1];
                $item = $item[0];
            }
            
            $classes[] = 'column-' . ($count+1);
            
            if ($count == 0) {
                $classes[] = 'first';
            }
            if ($count == count($row)-1) {
                $classes[] = 'last';
            }
            $classes[] = $count % 2 ? 'even' : 'odd';

            if (!empty($attribs['class'])) {
                $classes[] = $attribs['class'];
            }
            
            if ($classes) {
                $attribs['class'] = implode(' ', $classes);
            }

            if ($attribs) {
                $attribs = $this->_htmlAttribs($attribs);
            } else {
                $attribs = '';
            }
            
            if ($escape) {
                $item = $this->view->escape($item);
            }

            $output .= '<' . $tag . $attribs . '>' . $item . '</' . $tag . '>' . self::EOL;
            $count++;
        }
        
        return $output;
    }
    
    private function _sortableHtml($options)
    {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->addStylesheet('/application/modules/default/public/scripts/tablesorter/themes/epic/style.css');
        $this->view->jQuery()->addJavascriptFile('/application/modules/default/public/scripts/tablesorter/jquery.tablesorter.min.js');
//        $scriptOptions = "textExtraction: 'simple', "; //function(node) { alert(node.childNodes[0].innerHTML); return node.innerHTML; }, ';        
        $this->view->jQuery()->addOnLoad(' 
        	$.tablesorter.defaults.widgets = ["zebra"]; 
        	$.tablesorter.defaults.textExtraction = "simple"; 
        	$("table.tablesorter").tablesorter({' . $options . '});
    	'); 
    }
    
    private function _stickyHtml()
    {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $this->view->jQuery()->addStylesheet('/application/modules/default/public/scripts/chromatable/css/style.css');
        $this->view->jQuery()->addJavascriptFile('/application/modules/default/public/scripts/chromatable/jquery.chromatable.js');
        $this->view->jQuery()->addOnLoad(' 
        	$("table.sticky").chromatable({
            	width: "100%", // specify 100%, auto, or a fixed pixel amount
            	height: "400px",
            	scrolling: "yes" // must have the jquery-1.3.2.min.js script installed to use
        	});
        ');
    }
}