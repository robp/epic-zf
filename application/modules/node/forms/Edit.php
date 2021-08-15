<?php

class Node_Form_Edit extends EPIC_Form
{
    public function init()
    {
        if ($this->getAttrib('type')) {
            $type = $this->getAttrib('type');
        }
        elseif ($this->getAttrib('node')) {
            $node = $this->getAttrib('node');
            $type = $node->Type;
            $this->setAttrib('type', $type);
        }
        
        if ($type->hasTitle) {
            $title = new Node_Form_Element_Title('title');
            $title->setLabel($type->titleLabel);
            $this->addElement($title);
        }

        if ($type->hasBody) {
            $body = new Node_Form_Element_Body('body');
            $body->setLabel($type->bodyLabel);
            $this->addElement($body);
        }
        
        $this->addElement(new Node_Form_Element_Teaser('teaser'));

        $acl = Zend_Registry::get('acl');
        $user = Zend_Registry::get('user');
        
        if ($user->isAllowed('node:publishing options', 'administer')) {
            $published = new EPIC_Form_Element_CheckboxOption('published');
            $published->setLabel('Published');
            $this->addElement($published);
    
            $sticky = new EPIC_Form_Element_CheckboxOption('sticky');
            $sticky->setLabel('Sticky at top of lists');
            $this->addElement($sticky);
            
            $this->addDisplayGroup(array('published', 'sticky'), 'publishing_options', array(
            	'order' => 900,
            ));
            $this->getDisplayGroup('publishing_options')->setLegend('Publishing Options')
                                                        ->setAttrib('class', 'collapsibleClosed');
        }

        $this->getDisplayGroup('buttons')->addElement(
            new Zend_Form_Element_Submit('delete', array(
            'label' => 'Delete...',
            'order' => 200
        )));
        
        $this->getElement('submit')->setLabel('Save');
        
        $this->addNodeTypeElements();
    }

    public function addNodeTypeElements()
    {
        $front = Zend_Controller_Front::getInstance();
        $type = $this->getAttrib('type');
        
        list($module, $class) = explode('_Model_', $type->class);
        
        $elementDir = $front->getModuleDirectory(strtolower($module)) . "/forms/Element/{$class}";
        $classPrefix = "{$module}_Form_Element_{$class}";
        
        if (is_dir($elementDir)) {
            $files = scandir($elementDir);
            $elements = array();
        
            foreach ($files as $file) {
                $pos = strrpos($file, '.php');
                
                if ($pos) {
                    $class = substr($file, 0, $pos);
                    $class = "{$classPrefix}_{$class}";
                    $element = new $class('foo');
                    $elements[] = $element;
                }
            }
            
            if (count($elements)) {
                $fields = new EPIC_Form_SubForm();
                $fields->setLegend($type->title . ' fields')
                       ->addElements($elements);
                EPIC_Form::setLabelOptions($fields);
                $this->addSubForm($fields, 'Fields', 75);
            }
        }
    }
}
