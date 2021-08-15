<?php

class Ganalytics_Bootstrap extends EPIC_Application_Module_Bootstrap {
    // Bootstrap the module
    
    public function _initAnalytics()
    {
        $config = Zend_Registry::get('config');
        
        if (!empty($config->modules->ganalytics->account)) {
            $bootstrap = $this->getApplication();
            $bootstrap->bootstrap('view');
            $view = $bootstrap->getResource('view');
            
//            $view->inlineScript()->appendFile('http://www.google-analytics.com/urchin.js');
//            $view->inlineScript()->appendScript('
//_uacct = "' . $view->escape($config->modules->ganalytics->account) . '";
//urchinTracker();
//');
            $view->inlineScript()->appendScript('
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
');
            $view->inlineScript()->appendScript('
try{
var pageTracker = _gat._getTracker("' . $view->escape($config->modules->ganalytics->account) . '");
pageTracker._trackPageview();
} catch(err) {}
');
        }
    }
}


