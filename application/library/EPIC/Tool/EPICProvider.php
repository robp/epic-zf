<?php

require_once dirname(__FILE__) . "/../Exception.php";

/**
 * Doctrine Tool Provider
 *
 * @author Rob Pinciuc (rob@pinciuc.com)
 */
class EPIC_Tool_EPICProvider extends Zend_Tool_Project_Provider_Abstract
    implements Zend_Tool_Framework_Provider_Pretendable
{

    public function hello()
    {
        $this->_print('Hello');
    }
    
    /**
     * @param string $line
     * @param array $decoratorOptions
     */
    protected function _print($line, array $decoratorOptions = array())
    {
        $this->_registry->getResponse()->appendContent("[EPIC] " . $line, $decoratorOptions);
    }
}