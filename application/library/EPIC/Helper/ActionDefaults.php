<?php

/**
 * Action Helper for setting up all action controllers.
 * 
 * @uses Zend_Controller_Action_Helper_Abstract
 */
class EPIC_Helper_ActionDefaults extends Zend_Controller_Action_Helper_Abstract 
{

    public function init()
    {
        $config = Zend_Registry::get('config');
        $moduleName = $this->getRequest()->getModuleName();
        
        $controller = $this->getActionController();
        
        $controller->_moduleName = $moduleName;
        $controller->_moduleDirectory = $this->getFrontController()->getModuleDirectory($moduleName);
        
        if (isset($config->modules->$moduleName)) {
            $controller->_moduleConfig = $config->modules->$moduleName;
        }
        
        $controller->_messages = array();

        
        // Store the last referer in the session for easy redirecting
        // after some tasks.
        $requestUri = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        $session = Zend_Registry::get('session');
        
        if (isset($_SERVER['HTTP_REFERER'])) {
            if ($requestUri != $_SERVER['HTTP_REFERER']) {
                $session->referer = $_SERVER['HTTP_REFERER'];
            }
        }
    }

    public function postDispatch()
    {
        $controller = $this->getActionController();
        $controller->view->messages = array();

        $flashMessenger = $controller->getHelper('flashMessenger');
        
        foreach ($flashMessenger->getMessages() as $text) {
            $message = new EPIC_Model_Message(EPIC_Model_Message::TYPE_INFO, NULL, $text);
            $controller->view->messages[] = $message;
        }
        
        foreach ($controller->_messages as $message) {
            $controller->view->messages[] = $message;
        }
    }
}
