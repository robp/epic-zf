<?php

class Ckeditor_Form_Node_Form_Edit_Alter
{
    
    public function alter($form)
    {
        
        foreach ($form->getElements() as $element) {
            if (is_a($element, 'Zend_Form_Element_Textarea')) {
                $element->setAttrib('class', trim($element->getAttrib('class') . ' ckeditor'));

                $view = Zend_Layout::getMvcInstance()->getView();
                $view->jQuery()->enable();
//                $view->jQuery()->addStylesheet('/application/modules/default/public/scripts/textarearesizer/styles/style.css');
                $view->jQuery()->addJavascriptFile('/application/modules/ckeditor/public/ckeditor/ckeditor.js');
                $view->jQuery()->addJavascriptFile('/application/modules/ckeditor/public/ckeditor/adapters/jquery.js');
                $view->jQuery()->addOnLoad('
                	$("textarea.ckeditor").ckeditor( { toolbar : "Basic" });
                ');
            }
        }
    }
}
