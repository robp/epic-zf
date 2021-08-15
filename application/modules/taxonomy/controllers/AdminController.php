<?php

/**
 * AdminController
 * 
 * @author
 * @version 
 */

class Taxonomy_AdminController extends Zend_Controller_Action
{

    public function indexAction()
    {
        
    }

    public function vocabulariesAction()
    {
        $vocabularies = Taxonomy_Model_Vocabulary::getVocabulariesByNodetypeId();
        $this->view->vocabularies = $vocabularies;
    }

    public function vocabularycreateAction()
    {
        
        // action body
        $form = new Taxonomy_Form_Vocabulary_Create();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) { 
//                $form->process($user);
                
                $vocabulary = new Taxonomy_Model_Vocabulary();
                $vocabulary->fromArray($form->getValues());
                $vocabulary->save();
                    
                try {
                    $form->processSubForms(array('vocabulary' => $vocabulary));
                }
                catch (Exception $e) {
                    switch ($e->getCode()) {
                        default:
                            $this->_messages[] = new EPIC_Model_Message(
                                EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                    }
                }

                if (empty($e)) {
                    $this->_helper->flashMessenger->addMessage("Vocabulary '". $vocabulary->name . "' created.");
                    $this->_helper->redirector->gotoRoute(array('action' => 'vocabularies'), 'adminTask');
                }
            }
        }
        
        $this->view->form = $form;
    }
    
    public function vocabularyeditAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $vocabulary = Doctrine_Core::getTable('Taxonomy_Model_Vocabulary')->find($id);
        
        $form = new Taxonomy_Form_Vocabulary_Edit(array('vocabulary' => $vocabulary));
        
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getParam('delete')) {
                $this->_helper->redirector->gotoRoute(array('action' => 'vocabularydelete'), 'adminTask');
            }
            
            if ($form->isValid($this->getRequest()->getPost())) {
//                $form->process($user);
                
                $nodetypeValues = array();
                $nodetypes = array();
                
                foreach ($form->getValue('nodetypes') as $key => $val) {
                    if ($val) {
                        $nodetypeValues[] = $key;
                    }
                }
                
                if (count($nodetypeValues)) {
                    $q = Doctrine_Query::create()
                        ->select('*')
                        ->from('Node_Model_Type')
                        ->whereIn('name', $nodetypeValues);
                    
                    $nodetypes = $q->execute();
                }
                
                
                $vocabulary->fromArray($form->getValues());
                $vocabulary->unlink('Types');
                $vocabulary->save();
                
                foreach ($nodetypes as $nodetype) {
                    $vocabulary->Types[] = $nodetype;
                }
                
                $vocabulary->save();
                    
                try {
                    $form->processSubForms(array('vocabulary' => $vocabulary));
                }
                catch (Exception $e) {
                    switch ($e->getCode()) {
                        default:
                            $this->_messages[] = new EPIC_Model_Message(
                                EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                    }
                }

                if (empty($e)) {
                    $this->_helper->flashMessenger->addMessage('Changes saved.');
                    $this->_helper->redirector->gotoRoute(array('module' => 'taxonomy', 'action' => 'vocabularies'), 'adminTask', TRUE);
                }
            }
        }
        else {
            $form->setDefaults($vocabulary->toArray());
        }
        
        $this->view->vocabulary = $vocabulary;
        $this->view->form = $form;
    }
    
    public function vocabularydeleteAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $vocabulary = Doctrine_Core::getTable('Taxonomy_Model_Vocabulary')->find($id);
                
        $form = new Taxonomy_Form_Vocabulary_Delete(array('vocabulary' => $vocabulary));
        
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getParam('cancel')) {
                $this->_helper->redirector->gotoRoute(array('action' => 'vocabularyedit'), 'adminTask');
            }

            if ($form->isValid($this->getRequest()->getPost())) {
                $vocabulary->delete();

                try {
                    $form->processSubForms(array('vocabulary' => $vocabulary));
                }
                catch (Exception $e) {
                    switch ($e->getCode()) {
                        default:
                            $this->_messages[] = new EPIC_Model_Message(
                                EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                    }
                }

                if (empty($e)) {
                    $this->_helper->flashMessenger->addMessage("Vocabulary '" . $vocabulary->name . "' deleted.");
                    $this->_helper->redirector->gotoRoute(array('action' => 'vocabularies'), 'adminTask');
                }                
            }
        }
        
        $this->view->vocabulary = $vocabulary;
        $this->view->form = $form;
    }
    
    public function termsAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $vocabulary = Doctrine_Core::getTable('Taxonomy_Model_Vocabulary')->find($id);
        
        $terms = Taxonomy_Model_Vocabulary::getTermsByVocabularyId($vocabulary->id);

        $this->view->terms = $terms;
        $this->view->vocabulary = $vocabulary;
    }

    public function termcreateAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $vocabulary = Doctrine_Core::getTable('Taxonomy_Model_Vocabulary')->find($id);
        
        // action body
        $form = new Taxonomy_Form_Term_Create();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) { 
//                $form->process($user);
                
                $term = new Taxonomy_Model_Term();
                $term->fromArray($form->getValues());
                $term->Vocabulary = $vocabulary;
                $term->save();
                    
                try {
                    $form->processSubForms(array('term' => $term));
                }
                catch (Exception $e) {
                    switch ($e->getCode()) {
                        default:
                            $this->_messages[] = new EPIC_Model_Message(
                                EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                    }
                }

                if (empty($e)) {
                    $this->_helper->flashMessenger->addMessage("Term '". $term->name . "' created.");
                    $this->_helper->redirector->gotoRoute(array('action' => 'termcreate'), 'adminTask');
                }
            }
        }
        
        $this->view->vocabulary = $vocabulary;
        $this->view->form = $form;
    }

    public function termeditAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $term = Doctrine_Core::getTable('Taxonomy_Model_Term')->find($id);
        
        $form = new Taxonomy_Form_Term_Edit();
        
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getParam('delete')) {
                $this->_helper->redirector->gotoRoute(array('action' => 'termdelete'), 'adminTask');
            }
            
            if ($form->isValid($this->getRequest()->getPost())) {
//                $form->process($user);
                
                $term->fromArray($form->getValues());
                $term->save();
                    
                try {
                    $form->processSubForms(array('term' => $term));
                }
                catch (Exception $e) {
                    switch ($e->getCode()) {
                        default:
                            $this->_messages[] = new EPIC_Model_Message(
                                EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                    }
                }

                if (empty($e)) {
                    $this->_helper->flashMessenger->addMessage('Changes saved.');
                    $this->_helper->redirector->gotoRoute(array('action' => 'terms', 'id' => $term->Vocabulary->id), 'adminTask');
                }
            }
        }
        else {
            $form->setDefaults($term->toArray());
        }
        
        $this->view->term = $term;
        $this->view->form = $form;
    }
    
    public function termdeleteAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $term = Doctrine_Core::getTable('Taxonomy_Model_Term')->find($id);
                
        $form = new Taxonomy_Form_Term_Delete();
        
        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getParam('cancel')) {
                $this->_helper->redirector->gotoRoute(array('action' => 'termedit'), 'adminTask');
            }

            if ($form->isValid($this->getRequest()->getPost())) {
                $term->delete();
                
                try {
                    $form->processSubForms(array('term' => $term));
                }
                catch (Exception $e) {
                    switch ($e->getCode()) {
                        default:
                            $this->_messages[] = new EPIC_Model_Message(
                                EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                    }
                }

                if (empty($e)) {
                    $this->_helper->flashMessenger->addMessage("Term '" . $term->name . "' deleted.");
                    $this->_helper->redirector->gotoRoute(array('action' => 'terms', 'id' => $term->Vocabulary->id), 'adminTask');
                }
            }
        }
        
        $this->view->term = $term;
        $this->view->form = $form;
    }
}