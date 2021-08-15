<?php

class Contact_IndexController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $params = $this->getRequest()->getParams();
        
//        $formConfig = new Zend_Config_Ini(
//            $this->_moduleDirectory . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR .
//                 'contact.ini', APPLICATION_ENV, TRUE);
//        
//        if (isset($this->_moduleConfig->forms->contact)) {
//            $userFormConfig = $this->_moduleConfig->forms->contact;
//            $formConfig->merge($userFormConfig);
//        }
//        
//        $form = new Zend_Form($formConfig);
        $form = new Contact_Form_Contact();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
//                $datetime = date('M d Y H:i:s');
//                $ipAddress = $_SERVER['REMOTE_ADDR'];
//                $browser = $_SERVER['HTTP_USER_AGENT'];
//                
//                $this->view->name = $form->getValue('name');
//                $this->view->email = $form->getValue('email');
//                $this->view->url = $form->getValue('url');
//                $this->view->comment = $form->getValue('comment');
//                $this->view->datetime = $datetime;
//                $this->view->ipAddress = $ipAddress;
//                $this->view->browser = $browser;
//                
//                $message = $this->view->render(
//                    $this->getViewScript(
//                        'message'));
//                
//                $mail = new Zend_Mail();
//                $mail->setFrom(
//                    $this->_moduleConfig->email->from->address, 
//                    $this->_moduleConfig->email->from->name)->addTo(
//                    $this->_moduleConfig->email->to->address, 
//                    $this->_moduleConfig->email->to->name)->setSubject(
//                    $this->_moduleConfig->email->subject)->setBodyText(
//                    $message); /*->send();*/
//                
//                $redirector = $this->getHelper('Redirector');
//                $redirector->goto(
//                    isset(
//                        $params['_redir'][0]) ? $params['_redir'][0] : $params['action'], 
//                    isset(
//                        $params['_redir'][1]) ? $params['_redir'][1] : $params['controller'], 
//                    isset(
//                        $params['_redir'][2]) ? $params['_redir'][2] : $params['module']);
            }
        }
        
//        $form->setAction($params['action']);
        $this->view->form = $form;
        
        $this->_helper->viewRenderer->setNoRender(true);
        
        if ($this->_hasParam('_script')) {
            $script = $params['controller'] . DIRECTORY_SEPARATOR . $params['_script'] .
                 '.' . $this->viewSuffix;
        } else {
            $script = $params['controller'] . DIRECTORY_SEPARATOR . $params['action'] .
                 '.' . $this->viewSuffix;
        }
        
        try {
            echo $this->view->render($script);
        } catch (Zend_Exception $e) {
            echo $this->view->render($this->getViewScript());
        }
    }

    public function sentAction()
    {
        // action body
    }
}
