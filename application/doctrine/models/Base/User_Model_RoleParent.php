<?php

/**
 * User_Model_Base_RoleParent
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $child_id
 * @property integer $parent_id
 * @property User_Model_Role $Child
 * @property User_Model_Role $Parent
 * 
 * @package    EPIC
 * @subpackage ##SUBPACKAGE##
 * @author     Rob Pinciuc <rob@pinciuc.com>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class User_Model_Base_RoleParent extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('role_parent');
        $this->hasColumn('child_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('parent_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('User_Model_Role as Child', array(
             'local' => 'child_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('User_Model_Role as Parent', array(
             'local' => 'parent_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}