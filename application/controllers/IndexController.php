<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
		
		
		// redirect to controller USER and action LIST when starting the application
		// $this->redirect($this->getHelper('url')->url(array('controller' => 'user', 'action' => 'list', null), 'default', true));
		
		// you also can write this:
		// $this->redirect('/user/list/');
    }
}

