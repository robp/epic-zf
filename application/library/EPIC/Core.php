<?php

class EPIC_Core
{
    // The Zend_Date format for the Doctrine timestamp column type.
    const TIMESTAMP_FORMAT = 'y-MM-dd HH:mm:ss';
    
    public static function getModuleAutoloadersByResourceType($type = NULL)
    {
        $results = array();
        $autoloaders = Zend_Loader_Autoloader::getInstance()->getAutoloaders();
        
        foreach ($autoloaders as $autoloader) {
            if ($autoloader instanceof Zend_Application_Module_Autoloader) {
                
                if ($type == NULL || $autoloader->hasResourceType($type)) {
                    $resourceTypes = $autoloader->getResourceTypes();
                    $results[$autoloader->getNamespace()] = $resourceTypes['form'];
                }
            }
        }
        
        return $results;
    }
}