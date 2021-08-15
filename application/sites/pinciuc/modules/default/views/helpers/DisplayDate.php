<?php
class Pinciuc_View_Helper_DisplayDate
{
    function displayDate($dateStr, $format = Zend_Date::DATE_LONG)
    {
        $time = strtotime($dateStr);
        $date = new Zend_Date($time, 'en_GB');
        return $date->get($format);
    }
}