<?php

class Comment_Form_Node_Form_Delete_SubForm extends EPIC_Form_SubForm 
{
    public function init()
    {
        $id = (int) Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $node = Doctrine_Core::getTable('Node_Model_Node')->find($id);
        if (count($node->Comments)) {
            $message = 'Warning: This node has ' . count($node->Comments) . ' comment(s)! These will also be deleted.';
            $warning = new EPIC_Form_Element_Message('comment_warning');
            $warning->setLabel($message);
            $this->addElement($warning);
        }
        
        $this->setLegend('Comments');
    }
}