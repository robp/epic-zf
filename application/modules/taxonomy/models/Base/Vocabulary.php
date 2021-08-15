<?php

/**
 * Taxonomy_Model_Base_Vocabulary
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property clob $description
 * @property string $help
 * @property bool $tags
 * @property bool $multiple
 * @property bool $required
 * @property integer $weight
 * @property Doctrine_Collection $Terms
 * @property Doctrine_Collection $Types
 * @property Doctrine_Collection $Taxonomy_Model_VocabularyNodetype
 * 
 * @package    EPIC
 * @subpackage ##SUBPACKAGE##
 * @author     Rob Pinciuc <rob@pinciuc.com>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class Taxonomy_Model_Base_Vocabulary extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('vocabulary');
        $this->hasColumn('name', 'string', 80, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => '80',
             ));
        $this->hasColumn('description', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('help', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('tags', 'bool', null, array(
             'type' => 'bool',
             ));
        $this->hasColumn('multiple', 'bool', null, array(
             'type' => 'bool',
             ));
        $this->hasColumn('required', 'bool', null, array(
             'type' => 'bool',
             ));
        $this->hasColumn('weight', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Taxonomy_Model_Term as Terms', array(
             'local' => 'id',
             'foreign' => 'vocabulary_id'));

        $this->hasMany('Node_Model_Type as Types', array(
             'refClass' => 'Taxonomy_Model_VocabularyNodetype',
             'local' => 'vocabulary_id',
             'foreign' => 'nodetype_id'));

        $this->hasMany('Taxonomy_Model_VocabularyNodetype', array(
             'local' => 'id',
             'foreign' => 'vocabulary_id'));
    }
}