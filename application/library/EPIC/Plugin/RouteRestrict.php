<?php

/**
 * Front controller plugin for restricting access to
 * system modules using the standard Zend router. Only 
 * allows access to "site routes" and user-defined routes. 
 * 
 * @uses Zend_Controller_Action_Helper_Abstract
 */

class EPIC_Plugin_RouteRestrict extends Zend_Controller_Plugin_Abstract
{

    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        $route = $router->getCurrentRoute();

        if (get_class($route) == 'Zend_Controller_Router_Route_Module') {
            $module = $request->getParam('module');
            $dir = SITE_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $module;
            
            if (!is_dir($dir)) {
                throw new Zend_Controller_Router_Exception('Page not found', 404);
            }
        }
    }
}