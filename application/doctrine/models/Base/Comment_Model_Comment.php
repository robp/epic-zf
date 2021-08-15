<?php

/**
 * Comment_Model_Base_Comment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property Node_Model_Node $CommentNode
 * @property Comment_Model_Comment_Fields $Fields
 * @property Doctrine_Collection $Comments
 * 
 * @package    EPIC
 * @subpackage ##SUBPACKAGE##
 * @author     Rob Pinciuc <rob@pinciuc.com>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class Comment_Model_Base_Comment extends Node_Model_Node
{
    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Node_Model_Node as CommentNode', array(
             'local' => 'field_comment_node_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Comment_Model_Comment_Fields as Fields', array(
             'local' => 'id',
             'foreign' => 'node_id'));

        $this->hasMany('Comment_Model_Comment_Fields as Comments', array(
             'local' => 'id',
             'foreign' => 'parent_id'));
    }
}