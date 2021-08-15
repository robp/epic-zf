<?php

class EPIC_Filter_Slug implements Zend_Filter_Interface
{
    public function filter($value)
    {
        // perform some transformation upon $value to arrive on $valueFiltered
        $valueFiltered = strtolower($value);
        $valueFiltered = preg_replace('/[^a-z0-9\-]/', '', $valueFiltered);
        return $valueFiltered;
    }
}