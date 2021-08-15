<?php

/**
 * Node_Model_Base_Node_Fields
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $node_id
 * 
 * @package    EPIC
 * @subpackage ##SUBPACKAGE##
 * @author     Rob Pinciuc <rob@pinciuc.com>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class Node_Model_Base_Node_Fields extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('node__model__node__fields');
        $this->hasColumn('node_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}