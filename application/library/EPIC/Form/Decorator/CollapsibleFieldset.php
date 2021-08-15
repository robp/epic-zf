<?php

class EPIC_Form_Decorator_CollapsibleFieldset extends Zend_Form_Decorator_Fieldset 
{
    
    public function __construct($options = null)
    {
        parent::__construct($options);
        
        $view = Zend_Layout::getMvcInstance()->getView();
        $view->jQuery()->enable();
        $view->jQuery()->addStylesheet('/application/modules/default/public/scripts/collapsible/styles/style.css');
        $view->jQuery()->addJavascriptFile('/application/modules/default/public/scripts/collapsible/jquery.collapsible-v2.1.2.js');
        $view->jQuery()->addOnLoad('
			$("fieldset.collapsible").collapse();
			$("fieldset.collapsibleClosed").collapse( { closed : true } );
        ');
    }
}