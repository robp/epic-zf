<?php 

/**
 * Access Control List plugin
 * 
 * @uses Zend_Controller_Plugin_Abstract
 */
class User_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    
    /**
     * Router startup hook.
     * 
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function routeStartup()
    {
        $view     = Zend_Layout::getMvcInstance()->getView();
        $roleAnon = Doctrine_Core::getTable('User_Model_Role')->find(1);
        $roleAuth = Doctrine_Core::getTable('User_Model_Role')->find(2);
        $acl      = Zend_Registry::get('acl');
        
        if ($acl) {
            $view->navigation()->setAcl($acl);
        }

        if ($roleAnon) {
            $view->navigation()->setDefaultRole($roleAnon);
        }

        if (!Zend_Auth::getInstance()->hasIdentity()) {
            if ($roleAnon) {
                $view->navigation()->setRole($roleAnon);
            }
        }
        else {
            // $user gets set in user module's Bootstrap.php.
            $user   = Zend_Registry::get('user');
            $layout = Zend_Layout::getMvcInstance();

            // Assign the current user to the layout.
            $layout->user = $user;
            
//            TODO: Find out how to use multiple roles with the navigation() view helper.
            if (count($user->Roles)) {
                foreach ($user->Roles as $role) {
                    $view->navigation()->setRole($role);
                }
            }
            else {
                $view->navigation()->setRole($roleAuth);
            }
        }
    }

    /**
     * Route shutdown hook.
     * 
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
//    public function routeShutdown(Zend_Controller_Request_Abstract $request)
//    {
//        TODO: Need to eliminate double-rendering of layout if something in this function fails.
//        $view   = Zend_Layout::getMvcInstance()->getView();
//        $activePage = $view->navigation()->findActive($view->navigation()->getContainer());
        
        // @var Zend_Acl
//        $acl = Zend_Registry::get('acl');
//        Zend_Debug::dump($acl->isAllowed());
        
//        if (!$acl->isAllowed()) {
            // Active page not found. This should be due to a missing menu item, or
            // because the ACL does not permit the current page to be seen.
//            throw new Zend_Controller_Action_Exception('You are not authorized to view this resource', 401);
//        }
        
//        return $request;
//    }
}
