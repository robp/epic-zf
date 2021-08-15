<?php

class EPIC_Application_Module_Bootstrap extends Zend_Application_Module_Bootstrap
{
    /* Add my module configuration to the global config object */
    function _initConfig()
    {
        $front = Zend_Controller_Front::getInstance();
        
        // get the global config object
        $config = Zend_Registry::get('config');
        
        // load my module config
        $module = strtolower($this->getModuleName());
        
        $configFile = implode(DIRECTORY_SEPARATOR, array($front->getModuleDirectory($module), 'configs', 'module.ini'));
        
        if (is_readable($configFile)) {
            $moduleConfig = new Zend_Config_Ini($configFile, 
                APPLICATION_ENV, TRUE);
        }
        
        // merge module config into global config and store again in the registry
        if (isset($moduleConfig)) {
            if (isset($config->modules->$module)) {
                // site.ini config data, already loaded, should override module bootstrap config.ini 
                // data. So, merge the existing data (from site.ini) into the module bootstrap config.ini
                // and place that into the global config.
                $moduleConfig->merge(
                    $config->modules->$module);
                $config->modules->$module = $moduleConfig;
            } else {
//                Zend_Debug::dump($config);
                $config->modules->$module = $moduleConfig;
            }
            
            Zend_Registry::set('config', $config);
        }
    }

    /* Add my library folder to the include path */
    protected function _initLibrary()
    {
        $front = Zend_Controller_Front::getInstance();
        $module = strtolower($this->getModuleName());
        $library = realpath($front->getModuleDirectory($module) . DIRECTORY_SEPARATOR . 'library');
        
        if (is_dir($library)) {
            $autoloader = Zend_Loader_Autoloader::getInstance();
            $autoloader->registerNamespace(ucfirst($module) . '_');
            
            set_include_path(implode(PATH_SEPARATOR, array($library, get_include_path())));
        }        
    }
    
    /* Add my view helpers to the view helper path. */
    public function _initViewHelpers()
    {
        $front = Zend_Controller_Front::getInstance();
        $module = strtolower($this->getModuleName());
        $helperPath = implode(DIRECTORY_SEPARATOR, array($front->getModuleDirectory($module), 'views', 'helpers'));
             
        if (is_dir($helperPath)) {
            $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
            $viewRenderer->view->addHelperPath($helperPath, ucfirst($module) . '_View_Helper');
        }
    }
}
