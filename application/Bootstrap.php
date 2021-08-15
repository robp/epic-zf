<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    private function _getSiteBaseUrl($siteDirName = NULL)
    {
        return DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, array('application', 'sites',
            $this->_getSiteDirName($siteDirName), 'public'));
    }

    private function _getSitePath($siteDirName = NULL)
    {
        if (! isset($siteDirName)) {
            $siteDirName = $this->_getSiteDirName();
        }
        
        return  implode(DIRECTORY_SEPARATOR, array(APPLICATION_PATH, 'sites', $siteDirName));
    }

    private function _getSiteDirName()
    {
        if (isset($_SERVER['SERVER_NAME']) && file_exists(
            $this->_getSitePath($_SERVER['SERVER_NAME']))) {
            return $_SERVER['SERVER_NAME'];
        } else {
            return 'default';
        }
    }

//    protected function _initAutoload()
//    {
          // Initialize the autoloader for things like front controller plugins
          // or view plugins (this is not for /library files).

//        $autoloader = new Zend_Application_Module_Autoloader(
//            array('namespace' => 'EPIC_' , 
//                'basePath' => APPLICATION_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'default'));
//        return $autoloader;
//    }

//    http://www.rmauger.co.uk/2010/01/keeping-your-html-valid-with-zend-framework-tidy-and-firebug/
//    protected function _initWildFire()
//    {
//        //Don't use in production!
//        if (APPLICATION_ENV != 'development') {
//           return;
//        }
//        $this->bootstrap('db');
//        $db = Zend_Db_Table::getDefaultAdapter();
//        $profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
//        $profiler->setEnabled(true);
//        $db->setProfiler($profiler);
//        $writer = new Zend_Log_Writer_Firebug();
//        $logger = new Zend_Log($writer);
//        Zend_Registry::set('logger', $logger);
//    }
        
    protected function _initMultisiteDefs()
    {
        // Some definitions for the multisite installation.
        // These may be used in site.ini so they must be defined before _initMultisiteCofigs runs!
        define('SITE_PATH', $this->_getSitePath());
        define('SITE_BASEURL', $this->_getSiteBaseUrl());
    }

    /**
     * IMPORTANT: Must do this before we bootstrap any objects, so that any 
     * configuration done in the site.ini file will be recognized by the
     * actual resource object!
     */
    protected function _initMultisiteConfigs()
    {
        // Merge the site-specific config data into
        // the global config data. 
        $config = new Zend_Config($this->getOptions(), TRUE);
        
        // Initialize modules config section.
        if (!isset($config->modules)) {
            $config->modules = new Zend_Config(array(), TRUE);
        }
        
        $siteConfigFile = implode(DIRECTORY_SEPARATOR, array(SITE_PATH, 'configs', 'site.ini'));

        if (is_readable($siteConfigFile)) {
            $siteConfig = new Zend_Config_Ini($siteConfigFile, APPLICATION_ENV);
            $config->merge($siteConfig);
        }
        
        $this->setOptions($config->toArray());
        Zend_Registry::set('config', $config, TRUE);
    }

    /**
     * TODO: This might work for loading only the modules that a site
     * wants to have loaded. 
     */
//    public function _initModuleLoaders()
//    {
//        $this->bootstrap('Frontcontroller');
//
//        $fc = $this->getResource('Frontcontroller');
//        $modules = $fc->getControllerDirectory();
//
//        foreach ($modules AS $module => $dir) {
//            $moduleName = strtolower($module);
//            $moduleName = str_replace(array('-', '.'), ' ', $moduleName);
//            $moduleName = ucwords($moduleName);
//            $moduleName = str_replace(' ', '', $moduleName);
//
//            $loader = new Zend_Application_Module_Autoloader(array(
//                'namespace' => $moduleName,
//                'basePath' => realpath($dir . "/../"),
//            ));
//        }
//    }
    
    protected function _initMultisiteBaseurl()
    {
        // Set the baseUrl view helper to site's public directory.
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->getHelper('BaseUrl')->setBaseUrl(SITE_BASEURL);
    }
    
    protected function _initMultisiteModules()
    {
        // Add site-specific module path.
        $this->bootstrap('frontController');
        $front = $this->getResource('frontController');
        $front->addModuleDirectory(SITE_PATH . DIRECTORY_SEPARATOR . 'modules');
    }

    protected function _initMultisiteRoutes()
    {
        $configPath = implode(DIRECTORY_SEPARATOR, array(SITE_PATH, 'configs', 'routes.ini'));
        
        if (is_readable($configPath)) {
            $config = new Zend_Config_Ini($configPath, APPLICATION_ENV);

            if ($config->routes) {
                $this->bootstrap('frontController');
                
                /* @var $router Zend_Controller_Router_Rewrite */
                $router = $this->getResource('frontController')->getRouter();
                $router->addConfig($config, 'routes');
            }
        }
    }
    
    protected function _initDoctrine()
    {
//        $this->bootstrap('autoload');
        $this->bootstrap('multisiteDefs');
        $this->bootstrap('multisiteConfigs');

        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Doctrine_')
                   ->pushAutoloader(array('Doctrine_Core', 'autoload'));
                   
        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(Doctrine_Core::ATTR_AUTO_ACCESSOR_OVERRIDE, TRUE);
        $manager->setAttribute(Doctrine_Core::ATTR_AUTOLOAD_TABLE_CLASSES, TRUE);
        
        // only do this if we're not generating. this causes models to get loaded
        // twice while generating, creating errors.
        if (!defined('DOCTRINE_GENERATE')) {
            $manager->setAttribute(Doctrine_Core::ATTR_MODEL_LOADING, Doctrine_Core::MODEL_LOADING_CONSERVATIVE);
        }
        
        $doctrineConfig = $this->getOption('doctrine');
        $conn = Doctrine_Manager::connection($doctrineConfig['dsn'], 'doctrine');
        $conn->setAttribute(Doctrine_Core::ATTR_USE_NATIVE_ENUM, TRUE);
        return $conn;
    }

    protected function _initSession()
    {
        $this->bootstrap('multisiteConfigs');
//        $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
//        Zend_Session::setOptions(array('cookie_path' => $baseUrl));

//        TODO: Use our Doctrine database connection to store session data so that
//              we can support multiple web servers in a cluster sharing a database.
 
        $sessionConfig = new Zend_Config($this->getOption('session'));
        
        if (isset($sessionConfig->remember_me_seconds)) {
            Zend_Session::rememberMe($sessionConfig->remember_me_seconds);
        }
        $session = new Zend_Session_Namespace($sessionConfig->namespace);
        
        Zend_Registry::set('session', $session, TRUE);
        return $session;
    }

    protected function _initHelpers()
    {
        Zend_Controller_Action_HelperBroker::addPrefix('EPIC_Helper');
        
        // Create an ActionDefaults action helper so that its
        // hooks get called during the dispatch cycle.
        Zend_Controller_Action_HelperBroker::getStaticHelper('ActionDefaults');
    }
}
