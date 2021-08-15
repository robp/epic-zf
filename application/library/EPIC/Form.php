<?php

class EPIC_Form extends Zend_Form
{

    public function __construct($options = null)
    {
        $this->setAttribs(array(
        	'id' => $this->_getId(),
            'class' => 'epic-form',
        	'action' => $_SERVER['REQUEST_URI'],
        ));
        
        $this->setDefaultDisplayGroupClass('EPIC_Form_CollapsibleDisplayGroup');
        
        $this->addElement(new EPIC_Form_Element_Hash('epic_form_token'));

        $this->addElement('submit', 'submit', array(
            'label' => 'Submit',
            'ignore' => TRUE,
        	'order' => 100
        ));

        $this->addDisplayGroup(array('submit'), 'buttons', array(
        	'displayGroupClass' => 'EPIC_Form_BareDisplayGroup', 
        	'order' => 999
        ));
        
        // __construct() now so the above can be altered
        // with init(), since __construct() calls init().
        parent::__construct($options);

        // Call hooks.
        $this->_hookSubForm();
        $this->_hookFormAlter();
        
        self::setLabelOptions($this);
    }
    
    private function _getId()
    {
        $class = get_class($this);
        $formId = str_replace('_', '-', strtolower($class));
        return $formId;
    }
    
    private function _hookSubForm() {
        $autoloaders = EPIC_Core::getModuleAutoloadersByResourceType('form');
        
        foreach ($autoloaders as $namespace => $resource) {
            $class = $resource['namespace'] . '_' . get_class($this) . '_SubForm';
            
            if (@class_exists($class)) {
                $subForm = new $class($this->getAttribs());
                // Make sure the subform has elements or subforms, otherwise
                // we don't add it. This is because subforms might not add
                // elements based on the context (e.g., no vocabularies when 
                // creating a particular nodetype).
                
                
                $elementCount = count($subForm->getElements());
                $elementCount += count($subForm->getSubForms());
                $subFormName = strtolower($namespace) . '_subform';
                $this->addSubForm($subForm, $subFormName);

                // If there are no elements, just clear the decorators, so that the
                // subform's process() method still gets called (for example, when
                // deleting nodes, allow modules to add subforms and process them
                // but not have them show up on the Delete form itself.
                if (!$elementCount) {
                    $subForm->clearDecorators();
                }
                
            }
        }
    }
    
    private function _hookFormAlter() {
        $autoloaders = EPIC_Core::getModuleAutoloadersByResourceType('form');
        
        foreach ($autoloaders as $namespace => $resource) {
            $class = $resource['namespace'] . '_' . get_class($this) . '_Alter';

            if (@class_exists($class)) {
                $alter = new $class($this->getAttribs());
                $alter->alter($this);
            }
        }
    }
    
    public static function setLabelOptions($form)
    {
        foreach ($form->getElements() as $element) {
            if ($label = $element->getDecorator('Label')) {
                $label->setOption('escape', FALSE);
                
                if ($label->getPlacement() == Zend_Form_Decorator_Abstract::PREPEND) {
                    $label->setOption('optionalSuffix', ':')
                          ->setOption('requiredSuffix', ': <span class="form-required" title="This field is required.">*</span>');
                }
                else {
                    $label->setOption('requiredSuffix', ' *');
                }
            }
        }
    }
   
    public function process()
    {
    }

    public function processSubForms($options = array())
    {
        if (!isset($options['form'])) {
            $options['form'] = $this;
        }
        
        foreach ($this->getSubForms() as $subForm) {
            $subForm->process($options);
        }
    }
}