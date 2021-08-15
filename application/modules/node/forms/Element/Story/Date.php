<?php

class Node_Form_Element_Story_Date extends Zend_Form_Element_Text
{
    
    public function init()
    {
        $this->setName('story_date')
             ->setLabel('Story Date')
             ->setDescription('The date of the story in format "YYYY-MM-DD H24:MM:SS"')
             ->setOrder(101)
             ->addFilters(array('StripTags', 'StringTrim'));
    }
}