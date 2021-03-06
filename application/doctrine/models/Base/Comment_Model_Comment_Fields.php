<?php

/**
 * Comment_Model_Base_Comment_Fields
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $parent_id
 * @property string $name
 * @property string $email
 * @property string $url
 * @property Comment_Model_Comment $Node
 * @property Comment_Model_Comment $Parent
 * 
 * @package    EPIC
 * @subpackage ##SUBPACKAGE##
 * @author     Rob Pinciuc <rob@pinciuc.com>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class Comment_Model_Base_Comment_Fields extends Node_Model_Node_Fields
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('comment__model__comment__fields');
        $this->hasColumn('parent_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('name', 'string', 80, array(
             'type' => 'string',
             'length' => '80',
             ));
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('url', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Comment_Model_Comment as Node', array(
             'local' => 'node_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Comment_Model_Comment as Parent', array(
             'local' => 'parent_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}