<?php

class Node_Core
{
    public static function getScriptName($node)
    {
        // TODO: allow the scripts to exist in the site's layout directory. currently viewRenderer($scriptName) prepends the controller name to the script, which causes problems.
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        $scriptName = 'node-' . $node->type;
        $scriptPath = Zend_Controller_Front::getInstance()->getRequest()->getControllerName(). '/' . $scriptName .  '.' . $viewRenderer->getViewSuffix();
        
        if (!$path = $viewRenderer->view->getScriptPath($scriptPath)) {
            $scriptName = 'node';
        }
        
        return $scriptName;
    }
}