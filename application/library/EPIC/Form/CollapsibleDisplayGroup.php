<?php 

class EPIC_Form_CollapsibleDisplayGroup extends Zend_Form_DisplayGroup 
{

    public function __construct($name, Zend_Loader_PluginLoader $loader, $options = null)
    {
        parent::__construct($name, $loader, $options);
        
        $decorators = $this->getDecorators();
        $this->clearDecorators();
        
        foreach ($decorators as $name => $decorator) {
            if ($name == 'Zend_Form_Decorator_Fieldset') {
                $this->addDecorator(new EPIC_Form_Decorator_CollapsibleFieldset());        
            }
            else {
                $this->addDecorator($decorator);
            }
        }
    }
    
    /**
     * Initialize the DisplayGroup.
     */
    public function init()
    {
        if (!strstr($this->getAttrib('class'), 'collapsibleClosed')) {
            $this->setAttrib('class', trim('collapsible ' . $this->getAttrib('class')));
        }
    }
}
