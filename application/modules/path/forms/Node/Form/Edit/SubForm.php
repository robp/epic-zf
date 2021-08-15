<?php

class Path_Form_Node_Form_Edit_SubForm extends EPIC_Form_SubForm
{

    public function __construct($options = null)
    {
        $acl = Zend_Registry::get('acl');
        $user = Zend_Registry::get('user');
        
        if ($user->isAllowed('path:url aliases', 'administer')) {
            parent::__construct($options);
        }
    }
    
    public function init()
    {
        $this->setLegend('URL path settings')
             ->setOrder(200);

        $autoalias = new EPIC_Form_Element_CheckboxOption('autoalias');
        $autoalias->setLabel('Automatic alias')
                  ->setDescription('An alias will be generated for you. If you wish to create your own alias below, untick this option.')
                  ->setAttrib('onclick', "document.getElementById('path_subform-route').disabled = this.checked");
        $this->addElement($autoalias);
        
        $route = new Path_Form_Element_Route('route');
        $this->addElement($route);
    }

    public function setDefaults(array $defaults)
    {
        parent::setDefaults($defaults);
        
        $routeName = Path_Core::getNodeRouteName($defaults['id']);
        $route = Doctrine_Core::getTable('Menu_Model_Route')->findOneByName($routeName);
        
        if (!empty($route->id)) {
            $node = Doctrine_Core::getTable('Node_Model_Node')->find($defaults['id']);
            
            $url = Path_Core::getTypeUrlByNode($node);
            if (!$url) {
                $url = $node->slug;
            }
            
            if ($url == $route->route) {
                $this->getElement('autoalias')->setChecked(TRUE);
                $this->getElement('route')->disabled = TRUE;
            }
            
            $this->getElement('route')->setValue($route->route);
        }
    }
    
    public function isValid($data)
    {
        // Add the NoRecordExists validator to the route element.
        
        // We need to check if we have a route already, and if so, add it
        // to the exclude clause of the validator so that we can reuse
        // the same route for our node.
        if ($this->getElement('route')) {
            
            $node = $this->getAttrib('node');
            
            if (!empty($node)) {
                $routeName = Path_Core::getNodeRouteName($node->id);
                $route = Doctrine_Core::getTable('Menu_Model_Route')->findOneByName($routeName);
            }
            
            $exclude = NULL;
    
            // Do we have a route already?
            if (isset($route->id)) {
                $exclude = array('field' => 'route','value' => $route->route);
            }
            
            $this->getElement('route')->addValidator(
                new EPIC_Validate_Doctrine_NoRecordExists(array('table' => 'Menu_Model_Route', 'field' => 'route', 'exclude' => $exclude))
            );
            
        }
        
        return parent::isValid($data);
    }

    public function process($context = array())
    {
        if (!$this->getElement('route')) {
            return;
        }
        
        $node = $context['node'];
        $routeName = Path_Core::getNodeRouteName($node->id);
        $route = Doctrine_Core::getTable('Menu_Model_Route')->findOneByName($routeName);
        
        $newRoute = $this->getValue('route');

        if ($this->getValue('autoalias')) {
            $url = Path_Core::getTypeUrlByNode($node);
            if ($url) {
                $newRoute = $url;
            }
            else {
                $newRoute = $node->slug;
            }

            // If a generated route exists, add a numeric suffix to it
            // to make it unique.
//            $validator = new EPIC_Validate_Doctrine_NoRecordExists(array('table' => 'Menu_Model_Route', 'field' => 'route'));
//            $count = 1;
//            $validRoute = $newRoute;
//            while (!$validator->isValid($validRoute)) {
//                $validRoute = $newRoute . '-' . $count++;
//            }
//            $newRoute = $validRoute;
        }
        
        // Do we have a route already?
        if (isset($route->id)) {
            // Yes. If we have a new value, update the existing route,
            // otherwise delete the existing route.
            if ($newRoute) {
                $route->route = $newRoute;
                $route->save();
            }
            else {
                // Delete associated menu items, since the route no longer exists.
                $item = Doctrine_Core::getTable('Menu_Model_Item')->findOneByRoute($route->name);
                if (!empty($item->id)) {
                    $item->delete();
                }
                $route->delete();
            }
        }
        elseif ($newRoute) {
            // We don't have a route, but we have a new route value,
            // so create a new route.
            $defaultRoute = Doctrine_Core::getTable('Menu_Model_Route')->findOneByName(Path_Core::getDefaultNodeRouteName());
            
            $route = new Menu_Model_Route();
            $route->fromArray(array(
                'name' => $routeName,
                'route' => $newRoute,
                'defaults' => array(
                    'module' => $defaultRoute->defaults['module'],
                    'controller' => $defaultRoute->defaults['controller'],
                    'action' => $defaultRoute->defaults['action'],
                    'id' => $node->id,
                )
            ));
     
            $route->save();

            // Add the new route to the current router, in
            // case we want to redirect to it during this request.
            $router = Zend_Controller_Front::getInstance()->getRouter();
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
