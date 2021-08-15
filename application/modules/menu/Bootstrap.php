<?php

class Menu_Bootstrap extends EPIC_Application_Module_Bootstrap {
    // Bootstrap the module

    protected function _initPlugins() {
        $bootstrap = $this->getApplication();
        $bootstrap->bootstrap('frontController');

        $front = $bootstrap->getResource('frontController');
//        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Menu_Plugin_Navigation());
    }

    protected function _initRoutes() {
        $bootstrap = $this->getApplication();
        $bootstrap->bootstrap('frontController');
        $bootstrap->bootstrap('doctrine');
        
        $front = $bootstrap->getResource('frontController');
//        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter(); // returns a rewrite router by default
        $routes = Doctrine_Core::getTable('Menu_Model_Route')->findAll();
        
        foreach ($routes as $route) {
            $router->addRoute($route->name,
                new Zend_Controller_Router_Route(
                	$route->route,
                    $route->defaults,
                    $route->reqs
                )
            );
        }
    }
}
