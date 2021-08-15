<?php

/**
 * Menu_Model_Menuitem
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    EPIC
 * @subpackage Menu
 * @author     Rob Pinciuc <rob@pinciuc.com>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class Menu_Model_Item extends Menu_Model_Base_Item
{
    
    public function getPage()
    {
        $page = Zend_Navigation_Page::factory($this->getData());
        self::assignAttribs($page);
        foreach ($this->getChildItems() as $item) {
            $newPage = $item->getPage();
            $page->addPage($newPage);
        }
        return $page;
    }
    
    public static function assignAttribs(Zend_Navigation_Page $page)
    {
        if ($page->type == 'mvc') {
            $page->setId(join('-', array($page->module, $page->controller, $page->action)));
            $page->setClass(join(' ', array(
                "module-{$page->module}", 
                "controller-{$page->controller}",
                "action-{$page->action}",
            )));
        }
        
        $page->setTitle($page->label);
    }

    public function getChildItems()
    {
        $q = Doctrine_Query::create()
            ->from('Menu_Model_Item')
            ->where('parent_id = ?', $this->id)
            ->orderBy('weight, label');
        
        return $q->execute();
    }
    
    public static function getByNodeId($id)
    {
        $routeName = Path_Core::getNodeRouteName($id);
        $item = Doctrine_Core::getTable('Menu_Model_Item')->findOneByRoute($routeName);
        
        if (!empty($item->id)) {
            return $item;
        }

        $routeName = Path_Core::getDefaultNodeRouteName();
        $q = Doctrine_Query::create()
            ->from('Menu_Model_Item')
            ->where('route = ?', 'nodeViewId')
            ->andWhere('params = ?', serialize(array('id' => $id)));

        $results = $q->execute();

        if (count($results)) {
            $item = $results[0];
            return $item;
        }
        
        return FALSE;
    }
}