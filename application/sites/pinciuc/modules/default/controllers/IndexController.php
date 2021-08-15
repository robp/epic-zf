<?php

class IndexController extends Zend_Controller_Action
{
    protected $_collectionId  = '757490-72157621821611955';
    protected $_collection;
    protected $_photosets;

    protected $_blogId  = '1020538993066458697';
    protected $_blog;

    public function init()
    {
        /* Initialize action controller here */
        $this->_collection = new Flickr_Model_Collection();
        $this->_collection->find($this->_collectionId);
        $this->_photosets = $this->_collection->getPhotosets();

        $this->_blog = new Blogger_Model_Blog();
        $this->_blog->find($this->_blogId);
    }
    
    protected function _getSetByTitle($title)
    {
        foreach ($this->_photosets as $set) {
            $cleanTitle = $this->view->cleanUrl($set->getTitle());
            if ($cleanTitle == $title) {
                return $set;
            }
        }
        
        return NULL;
    }
    
    public function indexAction()
    {
        $set1Name = 'portfolio-1';
        $photo1Name = 'lifeguard-boats-and-lake-ontario';
        
        $set1 = $this->_getSetByTitle($set1Name);
        
        $photoFinder = new Flickr_Model_Photo();
        $photos = $photoFinder->findByPhotosetId($set1->getId());
        
        foreach ($photos as $photo1) {
            $cleanTitle = $this->view->cleanUrl($photo1->getTitle());
            if ($cleanTitle == $photo1Name) {
                break;
            }
        }
        
        $set2Name = 'portfolio-1';
        $photo2Name = 'cloud-and-waves-at-sunset';
        
        $set2 = $this->_getSetByTitle($set1Name);
        
        $photoFinder = new Flickr_Model_Photo();
        $photos = $photoFinder->findByPhotosetId($set2->getId());
        
        foreach ($photos as $photo2) {
            $cleanTitle = $this->view->cleanUrl($photo2->getTitle());
            if ($cleanTitle == $photo2Name) {
                break;
            }
        }

        $this->view->set1 = $set1;
        $this->view->photo1 = $photo1;
        $this->view->set2 = $set2;
        $this->view->photo2 = $photo2;

        $entryFinder = new Blogger_Model_Entry();
        $entries = $entryFinder->findByBlogId($this->_blogId);
        
        $entries = array_slice($entries, 0, 3);

        $this->view->entries = $entries;
    }
    
    public function setupAction()
    {
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->view->layout()->disableLayout();
        echo '<pre>';

//        
//        echo "Creating roles.<br/>";
//        $roleAnon = Doctrine_Core::getTable('User_Model_Role')->findOneByName('anonymous user');
//        if (!$roleAnon) {
//            $roleAnon = new User_Model_Role();
//            $roleAnon->name = 'anonymous user';
//            $roleAnon->description = 'A user that has not logged in.';
//            $roleAnon->save();
//        }
//        
//        $roleAuth = Doctrine_Core::getTable('User_Model_Role')->findOneByName('authenticated user');
//        if (!$roleAuth) {
//            $roleAuth = new User_Model_Role();
//            $roleAuth->Parent = $roleAnon;
//            $roleAuth->name = 'authenticated user';
//            $roleAuth->description = 'A user that has logged in.';
//            $roleAuth->save();
//        }
//
//        $roleAdmin = Doctrine_Core::getTable('User_Model_Role')->findOneByName('administrator');
//        if (!$roleAdmin) {
//            $roleAdmin = new User_Model_Role();
//            $roleAdmin->Parent = $roleAuth;
//            $roleAdmin->name = 'administrator';
//            $roleAdmin->description = 'Cool users that get to do everything.';
//            $roleAdmin->save();
//        }
//        
//        echo "Creating permissions.<br/>";
//        $perm = Doctrine_Core::getTable('User_Model_Permission')->find(1);
//        if (!$perm) {
//            $perm = new User_Model_Permission();
//            $perm->module = 'user';
//            $perm->name = 'access own profile';
//            $perm->save();
//            $roleAuth->Permissions[] = $perm;
//            
//            $perm = new User_Model_Permission();
//            $perm->module = 'user';
//            $perm->name = 'register';
//            $perm->save();
//            $roleAnon->Permissions[] = $perm;
//            $roleAuth->Permissions[] = $perm;
//            $roleAuth->save();
//            $roleAuth->setAllowed($perm, FALSE);
//            
//            $perm = new User_Model_Permission();
//            $perm->module = 'user';
//            $perm->name = 'login';
//            $perm->save();
//            $roleAnon->Permissions[] = $perm;
//            $roleAuth->Permissions[] = $perm;
//            $roleAuth->save();
//            $roleAuth->setAllowed($perm, FALSE);
//            
//            $perm = new User_Model_Permission();
//            $perm->module = 'user';
//            $perm->name = 'access user profiles';
//            $perm->save();
//            $roleAnon->Permissions[] = $perm;
//            
//            $perm = new User_Model_Permission();
//            $perm->module = 'user';
//            $perm->name = 'change own password';
//            $perm->save();
//            $roleAuth->Permissions[] = $perm;
//            
//            $perm = new User_Model_Permission();
//            $perm->module = 'user';
//            $perm->name = 'logout';
//            $perm->save();
//            $roleAuth->Permissions[] = $perm;
//            
//            $perm = new User_Model_Permission();
//            $perm->module = 'user';
//            $perm->name = 'change own username';
//            $perm->save();
//            $roleAuth->Permissions[] = $perm;
//
//            $perm = new User_Model_Permission();
//            $perm->module = 'admin';
//            $perm->name = 'access admin menu';
//            $perm->save();
//            $roleAdmin->Permissions[] = $perm;
//            
//            $perm = new User_Model_Permission();
//            $perm->module = 'user';
//            $perm->name = 'administer permissions';
//            $perm->save();
//            $roleAdmin->Permissions[] = $perm;
//            
//            $perm = new User_Model_Permission();
//            $perm->module = 'user';
//            $perm->name = 'administer users';
//            $perm->save();
//            $roleAdmin->Permissions[] = $perm;
//
//            $perm = new User_Model_Permission();
//            $perm->module = 'menu';
//            $perm->name = 'administer menus';
//            $perm->save();
//            $roleAdmin->Permissions[] = $perm;
//            
//            $roleAnon->save();
//            $roleAuth->save();
//            $roleAdmin->save();
//        }
//
//        echo "Creating users.<br/>";
//        $user = Doctrine_Core::getTable('User_Model_User')->findOneByUsername('admin');
//        if (!$user) {
//            $user = new User_Model_User();
//            $user->Role = $roleAdmin;
//            $user->username = 'admin';
//            $user->password = md5('foobar');
//            $user->email_address = 'rob@pinciuc.com';
//            $user->status = User_Model_User::STATUS_ACTIVE;
//            $user->save();
//        }
//
//        $user = Doctrine_Core::getTable('User_Model_User')->findOneByUsername('admin');
//        if (!$user) {
//            $user = new User_Model_User();
//            $user->Role = $roleAdmin;
//            $user->username = 'admin';
//            $user->password = md5('foobar');
//            $user->email_address = 'rob@pinciuc.com';
//            $user->status = User_Model_User::STATUS_ACTIVE;
//            $user->save();
//        }
//        
////        if ($user->hasPermission('user', 'administer users')) {
////            Zend_Debug::dump('Has permission.');
////        }
////        else {
////            Zend_Debug::dump('Does not have permission.');
////        }
//        //        $perms = array();
////        foreach ($user->Roles as $role) {
////            $perms = array_merge($perms, $role->Permissions->toArray());            
////        }
////        Zend_Debug::dump($perms);
////        Zend_Debug::dump($user->Roles->Permissions->toArray());
////        foreach ($user->Roles as $role) {
////            Zend_Debug::dump($role->Permissions->toArray());
////        }
//        
//        // Removes all roles from the user.
////        $user->unlink('Roles');
////        $user->save();
//        
//        // Gets all roles and add them.
////        $roles = Doctrine_Core::getTable('User_Model_Role')->findAll();
////        $user->Roles = $roles;
//
//        // Creates new roles.
////        $user->Roles[0]->name = 'Authenticated User';
////        $user->Roles[1]->name = 'Administrator';
//        
//        // Creates a new collection of roles.
////        $roles = new Doctrine_Collection(Doctrine_Core::getTable('User_Model_Role'));
////        $roles[0]->name = 'Third Role';
////        $roles[1]->name = 'Fourth Role';
////        $user->Roles = $roles;
//        
//        echo "Creating menus.<br/>";
//        $name = 'system_menu';
//        $menu2 = Doctrine_Core::getTable('Menu_Model_Menu')->findOneByName($name);
//        if (!$menu2) {
//            $menu2 = new Menu_Model_Menu();
//            $menu2->name = $name;
//            $menu2->title = 'Navigation';
//            $menu2->description = 'The system navigation menu.';
//            $menu2->save();
//        }
//        
//        $name = 'primary_links';
//        $menu = Doctrine_Core::getTable('Menu_Model_Menu')->findOneByName($name);
//        if (!$menu) {
//            $menu = new Menu_Model_Menu();
//            $menu->name = $name;
//            $menu->title = 'Primary Links';
//            $menu->description = 'The main navigation menu.';
//            $menu->save();
//        }
//
//        echo "Creating menu items.<br/>";
//        $item = Doctrine_Core::getTable('Menu_Model_Menuitem')->findOneByLabel('Administer');
//        if (!$item) {
//            $item2 = new Menu_Model_Menuitem();
//            $item2->menu_id = $menu2->id;
//            $item2->label = 'Administer';
//            $item2->module = 'admin';
//            $item2->resource = 'admin:access admin menu';
//            $item2->save();
//            
//            $item2 = new Menu_Model_Menuitem();
//            $item2->menu_id = $menu2->id;
//            $item2->label = 'Your Profile';
//            $item2->module = 'user';
//            $item2->resource = 'user:access own profile';
//            $item2->save();
//
//            $item2 = new Menu_Model_Menuitem();
//            $item2->menu_id = $menu2->id;
//            $item2->label = 'Login';
//            $item2->module = 'user';
//            $item2->controller = 'login';
//            $item2->resource = 'user:login';
//            $item2->save();
//            
//            $item2 = new Menu_Model_Menuitem();
//            $item2->menu_id = $menu2->id;
//            $item2->label = 'Logout';
//            $item2->module = 'user';
//            $item2->controller = 'logout';
//            $item2->resource = 'user:logout';
//            $item2->save();
//
//            $item2 = new Menu_Model_Menuitem();
//            $item2->menu_id = $menu2->id;
//            $item2->label = 'Register';
//            $item2->module = 'user';
//            $item2->controller = 'register';
//            $item2->resource = 'user:register';
//            $item2->save();
//
//            $item3 = new Menu_Model_Menuitem();
//            $item3->parent_id = $item2->id;
//            $item3->menu_id = $menu2->id;
//            $item3->label = 'Success';
//            $item3->module = 'user';
//            $item3->controller = 'register';
//            $item3->action = 'success';
//            $item3->visible = FALSE;
//            $item3->save();
//
//            $item3 = new Menu_Model_Menuitem();
//            $item3->parent_id = $item2->id;
//            $item3->menu_id = $menu2->id;
//            $item3->label = 'Account Confirmation';
//            $item3->module = 'user';
//            $item3->controller = 'register';
//            $item3->action = 'confirm';
//            $item3->visible = FALSE;
//            $item3->save();
//            
//            $item2 = new Menu_Model_Menuitem();
//            $item2->menu_id = $menu->id;
//            $item2->label = 'Etc.';
//            $item2->controller = 'etc';
//            $item2->save();
//
//            $item3 = new Menu_Model_Menuitem();
//            $item3->parent_id = $item2->id;
//            $item3->menu_id = $menu->id;
//            $item3->label = 'About This Site';
//            $item3->controller = 'etc';
//            $item3->action = 'about';
//            $item3->save();
//            
//            $item3 = new Menu_Model_Menuitem();
//            $item3->parent_id = $item2->id;
//            $item3->menu_id = $menu->id;
//            $item3->label = 'Contact Me';
//            $item3->controller = 'etc';
//            $item3->action = 'contact';
//            $item3->save();
//
//            $item4 = new Menu_Model_Menuitem();
//            $item4->parent_id = $item3->id;
//            $item4->menu_id = $menu->id;
//            $item4->label = 'Sent';
//            $item4->controller = 'etc';
//            $item4->action = 'sent';
//            $item4->visible = FALSE;
//            $item4->save();
//            
//            $item3 = new Menu_Model_Menuitem();
//            $item3->parent_id = $item2->id;
//            $item3->menu_id = $menu->id;
//            $item3->label = 'Copyright Statement';
//            $item3->controller = 'etc';
//            $item3->action = 'copyright';
//            $item3->save();
//
//            $item2 = new Menu_Model_Menuitem();
//            $item2->menu_id = $menu->id;
//            $item2->label = 'Photography';
//            $item2->controller = 'photos';
//            $item2->save();
//
//            $item3 = new Menu_Model_Menuitem();
//            $item3->parent_id = $item2->id;
//            $item3->menu_id = $menu->id;
//            $item3->label = 'Set';
//            $item3->controller = 'photos';
//            $item3->action = 'set';
//            $item3->save();
//
//            $item3 = new Menu_Model_Menuitem();
//            $item3->parent_id = $item2->id;
//            $item3->menu_id = $menu->id;
//            $item3->label = 'Photo';
//            $item3->controller = 'photos';
//            $item3->action = 'photo';
//            $item3->save();
//            
//            $item2 = new Menu_Model_Menuitem();
//            $item2->menu_id = $menu->id;
//            $item2->label = 'Updates';
//            $item2->controller = 'updates';
//            $item2->save();
//
//            $item3 = new Menu_Model_Menuitem();
//            $item3->parent_id = $item2->id;
//            $item3->menu_id = $menu->id;
//            $item3->label = 'Date';
//            $item3->controller = 'updates';
//            $item3->action = 'date';
////            $item3->route = 'updatesDate';
//            $item3->save();
//
//            $item3 = new Menu_Model_Menuitem();
//            $item3->parent_id = $item2->id;
//            $item3->menu_id = $menu->id;
//            $item3->label = 'Category';
//            $item3->controller = 'updates';
//            $item3->action = 'category';
////            $item3->route = 'updatesCategory';
//            $item3->save();
//        }
//        
////        echo "Checking for ACL<br/>";
////        Zend_Debug::dump($this->getInvokeArgs()->getApplication);
//

        echo "Getting a node\n";
//        $node = new Node_Model_Node();
//        $node->link('User', array(1));
//        $node->title = 'This is the title.';
//        $node->body = 'This is some body text, woot!';
//        $node->teaser = 'The teaser goes here.';
//        $node->save();
        $node = Doctrine_Core::getTable('Node_Model_Node')->find(1);
        Zend_Debug::dump(get_class($node));
        Zend_Debug::dump($node->toArray());
        $node = Doctrine_Core::getTable('Node_Model_Node')->find(2);
        Zend_Debug::dump(get_class($node));
        Zend_Debug::dump($node->toArray());
        echo "Done.\n";
        
        echo "\nDone.</pre>";
    }
    
    public function dumpAction()
    {
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->view->layout()->disableLayout();
        echo Doctrine_Core::dumpData(NULL);
    }
}
