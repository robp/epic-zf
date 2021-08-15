<?php

class EPIC_Form_Element_ResizeableTextarea extends Zend_Form_Element_Textarea
{
    
    public function init()
    {
        $this->setAttribs(array(
            'rows' => 10,
            'class' => 'resizable'
        ));
        
        $view = Zend_Layout::getMvcInstance()->getView();
        $view->jQuery()->enable();
        $view->jQuery()->addStylesheet('/application/modules/default/public/scripts/textarearesizer/styles/style.css');
        $view->jQuery()->addJavascriptFile('/application/modules/default/public/scripts/textarearesizer/jquery.textarearesizer.compressed.js');
        $view->jQuery()->addOnLoad('
        	$("textarea.resizable:not(.processed)").TextAreaResizer();
        ');
    }
}