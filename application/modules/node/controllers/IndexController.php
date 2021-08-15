<?php

class Node_IndexController extends Zend_Controller_Action
{

    public function indexAction()
    {
        // action body
        $nodes = Doctrine_Core::getTable('Node_Model_Node')->findAll();
        $this->view->nodes = $nodes;
    }

    public function viewAction()
    {
//        Zend_Debug::dump($this->getRequest()->getParams());
        if ($this->getRequest()->getParam('id')) {
            $this->_forward('id');
        }
        else {
            $params = $this->getRequest()->getParams();
            unset($params['module']);
            unset($params['controller']);
            unset($params['action']);
            Zend_Debug::dump($params); 
//            $this->_forward('slug');
        }
    }
    
    public function idAction()
    {
        // action body
        $filters = array(
            'id' => 'Digits',
        );
        $validators = array(
            'id' => array(
                'presence' => 'required',
                'NotEmpty',
                new EPIC_Validate_Doctrine_RecordExists(array('table' => 'Node_Model_Node', 'field' => 'id'))
            ),
        );
        
        $input = new Zend_Filter_Input($filters, $validators, $this->getRequest()->getParams());
        
        $type = Doctrine_Core::getTable('Node_Model_Type')->findOneByName('comment');
        $form = new Node_Form_Create(array('type' => $type));
        
        if ($input->isValid()) {
            $node = Doctrine_Core::getTable('Node_Model_Node')->find($input->id);
            $this->view->layout()->title = $node->title;
            $this->view->node = $node;
            
            if ($this->getRequest()->isPost()) {
                if ($form->isValid($this->getRequest()->getPost())) {
//                    $comment = $form->process(array('node' => $node));

                    $comment = new Comment_Model_Comment();
                    $comment->fromArray($form->getValues());
                    $comment->published = TRUE;
                    $comment->CommentNode = $node;
                    
                    // If a user is logged in, use them as the comment author.
                    if (Zend_Auth::getInstance()->hasIdentity()) {
                        $comment->User = Zend_Registry::get('user');
                    }
                    
                    $comment->save();
                    
                    try {
                        $form->processSubForms(array('node' => $comment));
                    }
                    catch (Exception $e) {
                        switch ($e->getCode()) {
                            default:
                                $this->_messages[] = new EPIC_Model_Message(
                                    EPIC_Model_Message::TYPE_WARN, $e->getCode(), $e->getMessage());
                        }
                    }
    
                    if (empty($e)) {
                        $this->_helper->flashMessenger->addMessage('Comment created.');
                        $this->_helper->redirector->gotoUrl($node->getUrl() . '#comment-' . $comment->id);
                    }
                }
            }
        }
        else {
//            $this->_helper->redirector->
        }
        
        $this->view->form = $form;

        $scriptName = Node_Core::getScriptName($node);
        $this->_helper->viewRenderer($scriptName);
    }
    
    public function slugAction()
    {
        // action body
        $options = array(
        	'filterNamespace' => 'EPIC_Filter',
            'validatorNamespace' => 'Node_Validate');;

        $filters = array(
            'slug' => 'Slug',
        );
        $validators = array(
            'slug' => array(
                'presence' => 'required',
                'NotEmpty',
                'SlugExists',
            ),
        );

        $input = new Zend_Filter_Input($filters, $validators, $this->getRequest()->getParams(), $options);
        
        if ($input->isValid()) {
            $node = Doctrine_Core::getTable('Node_Model_Node')->findOneBySlug($input->slug);
//            Zend_Debug::dump(get_class($node));
//            Zend_Debug::dump($node->toArray());
            $this->view->layout()->title = $node->title;
            $this->view->node = $node;
        }
        else {
            foreach ($input->getMessages() as $messageArr) {
                foreach ($messageArr as $message) {
                    $this->_messages[] = new EPIC_Model_Message(
                        EPIC_Model_Message::TYPE_WARN, NULL, $message
                    );
                }
            }
        }

        $scriptName = Node_Core::getScriptName($node);
        $this->_helper->viewRenderer($scriptName);
    }
}
