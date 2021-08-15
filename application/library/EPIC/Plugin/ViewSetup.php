<?php

class EPIC_Plugin_ViewSetup extends Zend_Controller_Plugin_Abstract
{
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;
        
        $view->originalModule = $request->getModuleName();
        $view->originalController = $request->getControllerName();
        $view->originalAction = $request->getActionName();
        
//        $config = Zend_Registry::get('config');

//        if (isset($config->site->titleSeparator)) {
//            $view->headTitle()->setSeparator($config->site->titleSeparator);
//        }

//        if (isset($config->links)) {
//            foreach ($config->links as $link) {
//                $view->headLink()->headLink(str_replace('%VIEW_BASEURL%', $view->baseUrl(), $link));
//            }
//        }
//    
//        if (isset($config->stylesheets)) {
//            foreach ($config->stylesheets as $stylesheet) {
//                $view->headLink()->appendStylesheet(
//                    str_replace('%VIEW_BASEURL%', $view->baseUrl(), $stylesheet['href']),
//                    isset($stylesheet['media']) ? $stylesheet['media'] : NULL,
//                    isset($stylesheet['conditionals']) ? $stylesheet['conditionals'] : NULL,
//                    isset($stylesheet['extras']) ? $stylesheet['extras'] : NULL
//                );
//            }
//        }
//
//        if (isset($config->scripts)) {
//            foreach ($config->scripts as $script) {
//                $view->headScript()->appendFile(
//                    str_replace('%VIEW_BASEURL%', $view->baseUrl(), $script['href']),
//                    isset($script['type']) ? $script['type'] : NULL,
//                    isset($script['attrs']) ? $script['attrs'] : NULL
//                );
//            }
//        }
    }

    public function postDispatch()
    {
//        $config = Zend_Registry::get('config');
//        $view = $this->_view;
    }
}