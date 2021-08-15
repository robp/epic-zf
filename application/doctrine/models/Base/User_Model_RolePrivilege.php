<?php

/**
 * User_Model_Base_RolePrivilege
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $role_id
 * @property integer $privilege_id
 * @property boolean $allowed
 * @property User_Model_Role $Role
 * @property User_Model_Privilege $Privilege
 * 
 * @package    EPIC
 * @subpackage ##SUBPACKAGE##
 * @author     Rob Pinciuc <rob@pinciuc.com>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class User_Model_Base_RolePrivilege extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('role_privilege');
        $this->hasColumn('role_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('privilege_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('allowed', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('User_Model_Role as Role', array(
             'local' => 'role_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('User_Model_Privilege as Privilege', array(
             'local' => 'privilege_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}