<?php

class Path_Core
{
    public static function getNodeRouteName($id)
    {
        return 'path_node_' . $id;
    }

    public static function getNodeTypeRouteName($id)
    {
        return 'path_nodetype_' . $id;
    }

    public static function getDefaultNodeRouteName()
    {
        return 'nodeViewId';
    }

    public static function getRouteByNode($node)
    {
        $routeName = self::getNodeRouteName($node->id);
        $route = Doctrine_Core::getTable('Menu_Model_Route')->findOneByName($routeName);
        
//        if (empty($route->id)) {
//            $routeName = self::getNodeTypeRouteName($node->Type->id);
//            $route = Doctrine_Core::getTable('Menu_Model_Route')->findOneByName($routeName);
//        }
//        
        if (empty($route->id)) {
            $routeName = self::getDefaultNodeRouteName();
            $route = Doctrine_Core::getTable('Menu_Model_Route')->findOneByName($routeName);
        }
        
        return $route;
    }

    public static function getRouteByNodeId($id)
    {
        $node = Doctrine_Core::getTable('Node_Model_Node')->find($id);
        return self::getRouteByNode($node);
    }

    public static function getTypeUrlByNode($node)
    {
        $url = NULL;
        
        if (!empty($node->Type->Path->route)) {
            $defaultRoute = Doctrine_Core::getTable('Menu_Model_Route')->findOneByName(Path_Core::getDefaultNodeRouteName());
            
            $route = new Menu_Model_Route();
            $route->fromArray(array(
                'route' => $node->Type->Path->route,
                'defaults' => array(
                    'module' => $defaultRoute->defaults['module'],
                    'controller' => $defaultRoute->defaults['controller'],
                    'action' => $defaultRoute->defaults['action'],
                    'id' => $node->id,
                )
            ));
            
            $final = new Zend_Controller_Router_Route(
            	$route->route,
                $route->defaults
            );
            
            $url = $final->assemble($node->getUrlParams());
        }
        
        return $url;
        
    }
    
    public static function getTypeUrlByNodeId($id)
    {
        $node = Doctrine_Core::getTable('Node_Model_Node')->find($id);
        return self::getTypeUrlByNode($node);
    }
}