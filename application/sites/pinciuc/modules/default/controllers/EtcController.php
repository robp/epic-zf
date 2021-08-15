<?php

class EtcController extends Zend_Controller_Action
{

    public function init()
    {    /* Initialize action controller here */
    }

    public function indexAction()
    {    // action body
    }

    public function contactAction()
    {
        $this->_forward('index', 'index', 'contact', array('_redir' => array('sent')));
    }

    public function sentAction()
    {    // action body
    }

    public function aboutAction()
    {    // action body
    }

    public function copyrightAction()
    {    // action body
    }
    
    public function sitemapAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->getResponse()->setHeader('Content-type', 'text/xml');
        echo $this->view->navigation()->sitemap();
    }
}
