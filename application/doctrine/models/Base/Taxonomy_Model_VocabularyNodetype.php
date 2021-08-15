<?php

/**
 * Taxonomy_Model_Base_VocabularyNodetype
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $vocabulary_id
 * @property integer $nodetype_id
 * @property Taxonomy_Model_Vocabulary $Vocabulary
 * @property Node_Model_Type $Type
 * 
 * @package    EPIC
 * @subpackage ##SUBPACKAGE##
 * @author     Rob Pinciuc <rob@pinciuc.com>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class Taxonomy_Model_Base_VocabularyNodetype extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('vocabulary_nodetype');
        $this->hasColumn('vocabulary_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('nodetype_id', 'integer', null, array(
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
        $this->hasOne('Taxonomy_Model_Vocabulary as Vocabulary', array(
             'local' => 'vocabulary_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Node_Model_Type as Type', array(
             'local' => 'nodetype_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}