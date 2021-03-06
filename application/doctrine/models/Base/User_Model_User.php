<?php

/**
 * User_Model_Base_User
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $username
 * @property string $password
 * @property string $email_address
 * @property integer $status
 * @property string $confirm_code
 * @property Doctrine_Collection $Roles
 * @property Doctrine_Collection $User_Model_UserRole
 * @property Doctrine_Collection $Nodes
 * 
 * @package    EPIC
 * @subpackage ##SUBPACKAGE##
 * @author     Rob Pinciuc <rob@pinciuc.com>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class User_Model_Base_User extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('user');
        $this->hasColumn('username', 'string', 40, array(
             'type' => 'string',
             'unique' => true,
             'notnull' => true,
             'length' => '40',
             ));
        $this->hasColumn('password', 'string', 32, array(
             'type' => 'string',
             'length' => '32',
             ));
        $this->hasColumn('email_address', 'string', 80, array(
             'type' => 'string',
             'unique' => true,
             'length' => '80',
             ));
        $this->hasColumn('status', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('confirm_code', 'string', 32, array(
             'type' => 'string',
             'length' => '32',
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('User_Model_Role as Roles', array(
             'refClass' => 'User_Model_UserRole',
             'local' => 'user_id',
             'foreign' => 'role_id'));

        $this->hasMany('User_Model_UserRole', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('Node_Model_Node as Nodes', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             'onInsert' => false,
             ));
        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'fields' => 
             array(
              0 => 'username',
             ),
             'canUpdate' => true,
             ));
        $this->actAs($timestampable0);
        $this->actAs($sluggable0);
    }
}