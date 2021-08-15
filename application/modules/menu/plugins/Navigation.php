<?php 

/**
 * Navigation initialization plugin
 * 
 * @uses Zend_Controller_Plugin_Abstract
 */
class Menu_Plugin_Navigation extends Zend_Controller_Plugin_Abstract
{

    /**
     * Route shutdown hook.
     * 
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
//        TODO: Need to eliminate double-rendering of layout if something in this function fails.
        $layout = Zend_Layout::getMvcInstance();
        $view   = Zend_Layout::getMvcInstance()->getView();
        $menus  = Doctrine_Core::getTable('Menu_Model_Menu')->findAll();
        
        // Create the active menu and the front page $frontPage. Do 
        // this so we can add the Front page to the top of the tree 
        // for navigation() helpers (e.g. breadcrumbs()) in the view.
        $activeMenu = new Zend_Navigation();
        
        // Create the front page.
        $frontPage = Zend_Navigation_Page::factory(array(
            'type' => 'mvc',
        	'module' => 'default',
        	'controller' => 'index',
        	'action' => 'index',
            'label' => 'Home',
            'route' => 'default',
            'reset_params' => TRUE
        ));
        Menu_Model_Item::assignAttribs($frontPage);
        $frontPage->setClass(join(' ', array($frontPage->class, 'front')));
        
        // Build the active menu for navigation. 
        if (count($menus)) {
            foreach ($menus as $menu) {
                $container = $menu->getContainer();
                $activePage = $view->navigation()->setRenderInvisible(TRUE)->findActive($container);
                if ($activePage) {
                    $frontPage->addPages($container->getPages());
                    break;
                }
            }
            
            if (!$activePage) {
                // Create the active page.
                $activePage = array();
                $page = Zend_Navigation_Page::factory(array(
                    'type' => 'mvc',
                	'module' => $request->getParam('module'),
                	'controller' => $request->getParam('controller'),
                	'action' => $request->getParam('action'),
                    'label' => 'Unknown Page',
                ));
                $activePage['page'] = $page;
                $frontPage->addPage($page);
            }
        }
        
        $activeMenu->addPage($frontPage);
        
        // Set $activeMenu as the default menu for the navigation() view helper. 
        $view->navigation($activeMenu);
        $view->navigation()->menu()->setRenderInvisible(TRUE);
        $view->navigation()->breadcrumbs()->setRenderInvisible(TRUE);

        if ($activePage) {
            $activePage = $activePage['page'];
            
            if ($activePage->label) {
                $layout->title = $activePage->label;
            }
            
            $layout->activePage = $activePage;
        }

        $layout->activeMenu = $activeMenu;
        $layout->frontPage = $frontPage;
        

        // Add the individual menus to the layout.
//        $menus  = Doctrine_Core::getTable('Menu_Model_Menu')->findAll();
//        if (count($menus)) {
//            foreach ($menus as $menu) {
////                $container = $menu->getContainer();
//                $layout->{$menu->name} = $menu;
//            }
//        }
        
        return $request;
    }
}
