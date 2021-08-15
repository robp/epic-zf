<?php

class Captcha_Form_SubForm_Captcha extends EPIC_Form_SubForm
{
    
    public function init()
    {
        $front = Zend_Controller_Front::getInstance();
        $modulePath = $front->getModuleDirectory('captcha');
        $modulePublicUrl = '/application/modules/captcha/public';
        
        $this->setLegend('Captcha');
        
        $this->addElement('captcha', 'captcha', array(
            'label' => 'Prove your humanity',
            'description' => 'Enter the text from the image above.',
            'captcha' => array(
            	'captcha' => 'Image',
                'wordLen' => 6,
                'fontSize' => 21,
                'font' => $modulePath . '/public/styles/fonts/Verdana.ttf',
                'imgDir' => $modulePath . '/public/images/captcha',
                'imgUrl' => $modulePublicUrl . '/images/captcha/',
            ),
            'required' => TRUE
        ));
    }
}
