<?php

class UserController extends Zend_Controller_Action
{

    protected $_thisUser = null;
    

    public function init()
    {
        /* Initialize action controller here */
		
		// check auth and get user
		if(Zend_Auth::getInstance()->hasIdentity()){
			$mapper = new Application_Model_Mappers_RawUser(); 
			$this->_thisUser = $mapper->fetchSingleById(Zend_Auth::getInstance()->getStorage()->read()->ID);
			$this->view->thisUser = $this->_thisUser;
		}
    }

    public function indexAction()
    {
        // action body
		
		// --> a simple way to test if database and mapper work
		
		// create mapper for model user
		$mapper = new Application_Model_Mappers_RawUser();
		
		// get all user from table RAW_USER
		$rows = $mapper->fetchList();		
		
		// show the result
		echo "Anzahl der User: " . count($rows);
		echo "<hr />";
        foreach ($rows as $row)
        {
            Zend_Debug::dump($row->toArray());
        }
		echo "<hr />";
    }

    public function listAction()
    {
        // action body
		
		// if already logged in otherwise redirect to start page
		if(!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));
		
		// create mapper for model user
		$mapper = new Application_Model_Mappers_RawUser();
		
		// get all user from table RAW_USER via mapper
		$rows = $mapper->fetchList();
		
		// pass the results to the view
		$this->view->users   = $rows;
		
		// now you can work with the array 'users' in
		// the view SUPERAPP\application\views\scripts\user\list.phtml
		// (and in all other views :-))
    }

    public function viewAction()
    {
        // action body
		
		// if already logged in otherwise redirect to start page
		if(!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));
		
		// create mapper for model user
		$mapper = new Application_Model_Mappers_RawUser();
		
		// get id from querystring
        $id = $this->getRequest()->getParam('id');
		
		// if id is not avaliable redirect to user list
		if(!$id) $this->redirect($this->getHelper('url')->url(array('controller' => 'user', 'action' => 'list', null), 'default', true));

		// get data from database via mapper
		$row = $mapper->fetchSingleById($id);
		
		if (!$row){
			return $this->_redirect($this->getHelper('url')->url(array('controller' => 'user', 'action' => 'list', null), 'default', true));
		}
		
		// pass the results to the view
		$this->view->user = $row;
		
		// now you can work with the array 'user' in
		// the view SUPERAPP\application\views\scripts\user\view.phtml
		// (and in all other views :-))
        
    }

    public function createAction()
    {
        // action body
		
		// if is NOT logged in - then he can registrate
		// and create a new user
		// otherwise he is logged in: then redirect to user dashboard or wherever you want
		if($this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'user', 'action' => 'dashboard', null), 'default', true));

		//get Formular Data
        $data = $this->getRequest()->getPost();

        if(!empty($data) && isset($data['Sign_up'])){
            // neuer Mapper für Model User
            $mapper=new Application_Model_Mappers_RawUser();

            // get daten von DB per Mapper
            $row=$mapper->create($data);

            if($row!=null){
                $this->_redirect($this->getHelper('url')->url(array('controller' => 'user', 'action' => 'login', null), 'default', true));
                $this->view->message="Success!";
            } else {
                $this->view->message="Something went wrong, try again!";
            }

        }

		$form = new Application_Form_UserCreate();

		$this -> view -> form = $form;


    }

    public function updateAction()
    {
         
		if (!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));

        // Formularinhalte vom Absenden holen
        $data = $this->getRequest()->getPost();

        // Überprüfung, dass Form NICHT leer ist und Button "Speichern" geklickt wurde
        if (!empty($data) && isset($data['Save'])) {

            // Daten von DB holen
            $mapper = new Application_Model_Mappers_RawUser();
            // Update in DB
            $row = $mapper->update($data['user_id'], $data);

            if ($row != null){
                $this->_redirect($this->getHelper('url')->url(array('controller' => 'files', 'action' => 'index', null), 'default', true));
            } else {
                $this->view->loginfail = "Die Bearbeitung ist fehlgeschlagen!";
            }
        }

        // Form erstellen und an View übergeben
        $form = new Application_Form_UserUpdate($this->_thisUser);
        $this->view->form = $form;
        // action body
		
		// when user is logged in
		// then he allowd to update himself
		//if(!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'user', 'action' => 'dashboard', null), 'default', true));
        
        // redirect to dashboard
       //return $this->_redirect($this->getHelper('url')->url(array('controller' => 'user', 'action' => 'dashboard'), 'default', true));
    }

    public function deleteAction()
    {
        // action body
		
		// only when user is logged in
		// otherwise redirect him to the start page
		if(!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));
		
		// create mapper for model user
		$mapper = new Application_Model_Mappers_RawUser();
		
		// get id from querystring
        $id = $this->getRequest()->getParam('id');
		
		// if id is not avaliable redirect to user list
		if(!$id) $this->redirect($this->getHelper('url')->url(array('controller' => 'user', 'action' => 'list', null), 'default', true));

		// get data from database via mapper
		$row = $mapper->fetchSingleById($id);
		
		// when user not found in database then return to user list
		if (!$row){
			return $this->_redirect($this->getHelper('url')->url(array('controller' => 'user', 'action' => 'list', null), 'default', true));
		}
		
		// get formular=request data
		$data = $this->getRequest()->getPost();
		
		// check, if formular has data AND has been submitted
		if(!empty($data) && !is_null($data['user_submit'])){
			// then delete user
			$mapper->delete($id);
			
			// and return to user list
			return $this->_redirect($this->getHelper('url')->url(array('controller' => 'user', 'action' => 'index'), 'default', true));
		}
		
		// --> if you reach this point, no formular has been shown
		// or submitted - so do it now
		
		// create new formular for deletion
		$form = new Application_Form_UserDelete();
		
		// fill in the user data into the formular fields
		$form->setDefaults($row->toArray());
		
		//$form->setAction($this->getHelper('url')->url(array('id' => $id)));
		
		// pass the results to the view
		$this->view->user = $row;
		$this->view->form = $form;
		
		// now you can work with the array 'user' and the variabel 'form'
		// ('form' contains the complete HTML-code of the formular which is
		// set in the file SUPERAPP\application\forms\UserDelete.php)
		// in the view SUPERAPP\application\views\scripts\user\delete.phtml
		// (and in all other views :-))
    }

    public function loginAction()
    {
        // action body
		
		// only when logged out = user is NOT logged in
		// see above: init()
		// if already logged in then redirect to dashboard or wherever you want
		if($this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'list', null), 'default', true));
		
		//Zend_Debug::dump($this->_thisUser);
		
		// create mapper for model user
		$mapper = new Application_Model_Mappers_RawUser();
		
		// get formular data
		$data = $this->getRequest()->getPost();
		
		// check, if formular has data AND has been submitted
		if(!empty($data) && !is_null($data['user_submit'])){
			// get email from request data
			$email = $data['user_email'];
			
			// get data from database via mapper
			// when email has a value
			if($email){
				//$row = $mapper->fetchSingleByEmail($email);
			}
		
			/* TODO: do action with mapper */
			$user = null;
			$auth = Zend_Auth::getInstance();
			$user = New Application_Model_DbTable_RawUser();
			$authAdapter = new Zend_Auth_Adapter_DbTable($user->getAdapter(),'RAW_USER');
			$authAdapter->setIdentityColumn('EMAIL')
						->setCredentialColumn('PASSWORD');
			$authAdapter->setIdentity($data['user_email'])
						->setCredential($data['user_password']);
			$result = $auth->authenticate($authAdapter);
			if($result->isValid()){
					
				$storage = new Zend_Auth_Storage_Session();
				$storage->write($authAdapter->getResultRowObject());
				
				// if you want to set a logindate in the table RAW_USER
				// then configure the mapper-function login()
				// and uncomment the following line
				/*
				$data = $storage->read();
				$email = $data->EMAIL;
				$user = $mapper->fetchSingleByEmail($email);
				$mapper->login($user->getId());
				*/
				
				// and return to dashboard or wherever you want
				return $this->_redirect($this->getHelper('url')->url(array('controller' => 'user', 'action' => 'dashboard'), 'default', true));
				
			} else {
				// wrong login data
				// do whatever is necessary
			}
			/* END TODO */
			
			
			
		}
		
		
		// --> if you reach this point, no formular has been shown
		// or submitted - so do it now
		
		// create new formular for deletion
		$form = new Application_Form_UserLogin();
		
		// pass the results to the view
		$this->view->form = $form;
		
		// now you can work with the array variable 'form'
		// ('form' contains the complete HTML-code of the formular which is
		// set in the file SUPERAPP\application\forms\UserLogin.php)
		// in the view SUPERAPP\application\views\scripts\user\login.phtml
		// (and in all other views :-))
    }

    public function logoutAction()
    {
        // action body
		
		// only when logged in!!!
		if(!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));
		
		// clear auth instance
		if(!Zend_Auth::getInstance()->clearIdentity()){
			// create message or do nothing
		}
		
		// destroy session
		if(!Zend_Session::destroy()){
			// create message or do nothing
		}
		
		// redirect to start page
		//$this->_redirect($this->getHelper('url')->url(array('controller' => 'user', 'login' => 'login', null), 'default', true));
    }

    public function dashboardAction()
    {
            // only when logged in!!!
        	if(!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));
        
        
            
        // form holen
      $form = new Application_Form_UserDashboard($this->_thisUser);
        $this->view->form = $form;


}

 public function uploadAction()
    {
        
        
    }

}













