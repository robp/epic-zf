<?php

/**
 * Node_Model_Base_Story_Fields
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $story_dateline
 * @property timestamp $story_date
 * @property Node_Model_Story $Node
 * 
 * @package    EPIC
 * @subpackage ##SUBPACKAGE##
 * @author     Rob Pinciuc <rob@pinciuc.com>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class Node_Model_Base_Story_Fields extends Node_Model_Node_Fields
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('node__model__story__fields');
        $this->hasColumn('story_dateline', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('story_date', 'timestamp', null, array(
             'type' => 'timestamp',
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Node_Model_Story as Node', array(
             'local' => 'node_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}