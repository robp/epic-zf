<?php

/**
 * Node_Model_Story
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    EPIC
 * @subpackage ##SUBPACKAGE##
 * @author     Rob Pinciuc <rob@pinciuc.com>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class Node_Model_Story extends Node_Model_Base_Story
{

    public function getUrlParams()
    {
        $params = parent::getUrlParams();
        
        if (!empty($this->Fields)) {
            $storydate = new Zend_Date($this->Fields->story_date, EPIC_Core::TIMESTAMP_FORMAT);
    
            $params['story_date-yyyy'] = $storydate->get(Zend_Date::YEAR);
            $params['story_date-yy'] = $storydate->get(Zend_Date::YEAR_SHORT);
            $params['story_date-month'] = $storydate->get(Zend_Date::MONTH_NAME);
            $params['story_date-mon'] = $storydate->get(Zend_Date::MONTH_NAME_SHORT);
            $params['story_date-mm'] = $storydate->get(Zend_Date::MONTH);
            $params['story_date-m'] = $storydate->get(Zend_Date::MONTH_SHORT);
            $params['story_date-ww'] = $storydate->get(Zend_Date::WEEK);
            $params['story_date-date'] = $storydate->get(Zend_Date::DATE_LONG);
            $params['story_date-day'] = $storydate->get(Zend_Date::WEEKDAY);
            $params['story_date-ddd'] = $storydate->get(Zend_Date::WEEKDAY_SHORT);
            $params['story_date-dd'] = $storydate->get(Zend_Date::DAY);
            $params['story_date-d'] = $storydate->get(Zend_Date::DAY_SHORT);
            $params['story_date-time'] = $storydate->get(Zend_Date::TIME_MEDIUM);
            $params['story_date-hour'] = $storydate->get(Zend_Date::HOUR);
            $params['story_date-hr'] = $storydate->get(Zend_Date::HOUR_SHORT);
            $params['story_date-hour12'] = $storydate->get(Zend_Date::HOUR_AM);
            $params['story_date-hr12'] = $storydate->get(Zend_Date::HOUR_SHORT_AM);
            $params['story_date-ampm'] = $storydate->get(Zend_Date::HOUR_AM);
            $params['story_date-minute'] = $storydate->get(Zend_Date::MINUTE);
            $params['story_date-min'] = $storydate->get(Zend_Date::MINUTE_SHORT);
            $params['story_date-second'] = $storydate->get(Zend_Date::SECOND);
            $params['story_date-sec'] = $storydate->get(Zend_Date::SECOND_SHORT);
            $params['story_date-z'] = $storydate->get(Zend_Date::TIMESTAMP);
        }
        
        return $params;
    }
}