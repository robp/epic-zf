<?php

class Comment_Form_Node_Form_Edit_Alter
{
    
    public function alter($form)
    {
        $type = $form->getAttrib('type');
        
        if ($type->name == 'comment') {
            $form->removeElement('teaser');
            
            if (Zend_Auth::getInstance()->hasIdentity()) {
//                $fields = $form->getSubForm('Fields');
//                $fields->removeElement('name');
//                $fields->removeElement('email');
//                $fields->removeElement('url');
            }
            else {
                $form->addSubForm(new Captcha_Form_SubForm_Captcha(), 'captcha', 800);
            }
        }
    }
}
