<?php

/**
 * Node_Model_Node
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    EPIC
 * @subpackage ##SUBPACKAGE##
 * @author     Rob Pinciuc <rob@pinciuc.com>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class Node_Model_Node extends Node_Model_Base_Node
{

    public function save(Doctrine_Connection $conn = null)
    {
        parent::save($conn);
    }
    
    public function getUrl($useType = FALSE)
    {
        $router  = Zend_Controller_Front::getInstance()->getRouter();
        $url = NULL;
        
        // First try the node's static route.
        $routeName = Path_Core::getNodeRouteName($this->id);
        $route = Doctrine_Core::getTable('Menu_Model_Route')->findOneByName($routeName);
        
        if (!empty($route->id)) {
            $final = $router->getRoute($route->name);
        }
        else {
            $final = $router->getRoute('nodeViewId');
        }
        
        if (isset($final)) {
            $url = $final->assemble($this->getUrlParams());
        }
        
        return $url;
    }
    
    public function getUrlParams()
    {
        $created = new Zend_Date($this->created_at, EPIC_Core::TIMESTAMP_FORMAT);
        $updated = new Zend_Date($this->updated_at, EPIC_Core::TIMESTAMP_FORMAT);
        $item = Menu_Model_Item::getByNodeId($this->id);

        $params = array();
        $params['id'] = $this->id;
        $params['type'] = $this->type;
        $params['type-id'] = $this->Type->id;
        $params['type-title'] = $this->Type->title;
        $params['title'] = $this->title;
        $params['slug'] = $this->slug;

        $params['published'] = $this->published;
        $params['sticky'] = $this->sticky;
        $params['version'] = $this->version;

        $params['yyyy'] = $created->get(Zend_Date::YEAR);
        $params['yy'] = $created->get(Zend_Date::YEAR_SHORT);
        $params['month'] = $created->get(Zend_Date::MONTH_NAME);
        $params['mon'] = $created->get(Zend_Date::MONTH_NAME_SHORT);
        $params['mm'] = $created->get(Zend_Date::MONTH);
        $params['m'] = $created->get(Zend_Date::MONTH_SHORT);
        $params['ww'] = $created->get(Zend_Date::WEEK);
        $params['date'] = $created->get(Zend_Date::DATE_LONG);
        $params['day'] = $created->get(Zend_Date::WEEKDAY);
        $params['ddd'] = $created->get(Zend_Date::WEEKDAY_SHORT);
        $params['dd'] = $created->get(Zend_Date::DAY);
        $params['d'] = $created->get(Zend_Date::DAY_SHORT);
        $params['time'] = $created->get(Zend_Date::TIME_MEDIUM);
        $params['hour'] = $created->get(Zend_Date::HOUR);
        $params['hr'] = $created->get(Zend_Date::HOUR_SHORT);
        $params['hour12'] = $created->get(Zend_Date::HOUR_AM);
        $params['hr12'] = $created->get(Zend_Date::HOUR_SHORT_AM);
        $params['ampm'] = $created->get(Zend_Date::HOUR_AM);
        $params['minute'] = $created->get(Zend_Date::MINUTE);
        $params['min'] = $created->get(Zend_Date::MINUTE_SHORT);
        $params['second'] = $created->get(Zend_Date::SECOND);
        $params['sec'] = $created->get(Zend_Date::SECOND_SHORT);
        $params['z'] = $created->get(Zend_Date::TIMESTAMP);

        $params['updated-yyyy'] = $updated->get(Zend_Date::YEAR);
        $params['updated-yy'] = $updated->get(Zend_Date::YEAR_SHORT);
        $params['updated-month'] = $updated->get(Zend_Date::MONTH_NAME);
        $params['updated-mon'] = $updated->get(Zend_Date::MONTH_NAME_SHORT);
        $params['updated-mm'] = $updated->get(Zend_Date::MONTH);
        $params['updated-m'] = $updated->get(Zend_Date::MONTH_SHORT);
        $params['updated-ww'] = $updated->get(Zend_Date::WEEK);
        $params['updated-date'] = $updated->get(Zend_Date::DATE_LONG);
        $params['updated-day'] = $updated->get(Zend_Date::WEEKDAY);
        $params['updated-ddd'] = $updated->get(Zend_Date::WEEKDAY_SHORT);
        $params['updated-dd'] = $updated->get(Zend_Date::DAY);
        $params['updated-d'] = $updated->get(Zend_Date::DAY_SHORT);
        $params['updated-time'] = $updated->get(Zend_Date::TIME_MEDIUM);
        $params['updated-hour'] = $updated->get(Zend_Date::HOUR);
        $params['updated-hr'] = $updated->get(Zend_Date::HOUR_SHORT);
        $params['updated-hour12'] = $updated->get(Zend_Date::HOUR_AM);
        $params['updated-hr12'] = $updated->get(Zend_Date::HOUR_SHORT_AM);
        $params['updated-ampm'] = $updated->get(Zend_Date::HOUR_AM);
        $params['updated-minute'] = $updated->get(Zend_Date::MINUTE);
        $params['updated-min'] = $updated->get(Zend_Date::MINUTE_SHORT);
        $params['updated-second'] = $updated->get(Zend_Date::SECOND);
        $params['updated-sec'] = $updated->get(Zend_Date::SECOND_SHORT);
        $params['updated-z'] = $updated->get(Zend_Date::TIMESTAMP);
        
        $params['author-id'] = $this->user_id;
        $params['author-slug'] = $this->User->slug; 
        $params['author-username'] = $this->User->username; 
        $params['author-role-id'] = $this->User->Roles[0]->id; 
        $params['author-email'] = $this->User->email_address; 
        $params['author-status'] = $this->User->status;

        if (!empty($this->Terms[0]->id)) {
            $params['term'] = $this->Terms[0]->name;
            $params['term-id'] = $this->Terms[0]->id;
            $params['vocabulary'] = $this->Terms[0]->Vocabulary->name;
            $params['vocabulary-id'] = $this->Terms[0]->Vocabulary->id;
        }
        
        if (!empty($item->id)) {
            $params['menu'] = $item->Menu->name;
            $params['menu-title'] = $item->Menu->title;
            $params['menu-id'] = $item->Menu->title;
            $params['menuitem-label'] = $item->label;
            $params['menuitem-id'] = $item->id;
        }
        
        return $params;
    }
}