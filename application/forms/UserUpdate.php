<?php
class Application_Form_UserUpdate extends Zend_Form{
    protected $_user;

    public function __construct($user)
    {
        $this->_user = $user;
        parent::__construct();
    }
    public function init(){

        $this->setMethod('POST');
		$this->setAttrib('class', 'form-signin');

        $id = new Zend_Form_Element_Hidden('user_id');
        $id->setRequired(true);
        $id->setAttribs(array('class' => 'input', 'placeholder' => 'Userid'));
        $id->setValue($this->_user->getId());

        

        // Firstname
        $firstname = new Zend_Form_Element_Text('user_firstname');
        $firstname->setLabel('Firstname*');
        $firstname->setRequired(true);
        $firstname->setAttribs(array('class' => 'form-control', 'placeholder' => 'Firstname', 'required' => ''));
        $firstname->setValue($this->_user->getFirstname());
        
        // lastname
        $lastname = new Zend_Form_Element_Text('user_lastname');
        $lastname->setLabel('Lastname*');
        $lastname->setRequired(true);
        $lastname->setAttribs(array('class' => 'form-control', 'placeholder' => 'Lastname', 'required' => ''));
        $lastname->setValue($this->_user->getLastname());
        
        // password
        $password = new Zend_Form_Element_password('user_password');
        $password->setLabel('Password*');
        $password->setRequired(true);
        $password->setAttribs(array('class' => 'form-control', 'placeholder' => 'Password', 'required' => ''));
        $password->setValue($this->_user->getPassword());
        
        // UserEmail
        $email = new Zend_Form_Element_Text('user_email');
        $email->setLabel('Email*');
        $email->setRequired(true);
        $email->setAttribs(array('class' => 'form-control', 'placeholder' => 'UserEmail'));
        $email->setValue($this->_user->getEmail());
     
        
        //Submit Button
        $submitbutton = new Zend_Form_Element_Button('Save');
        $submitbutton->setAttribs(array('type' => 'submit', 'class' => 'btn btn-logreg form-control'));
        $submitbutton->setValue('Update');
       
         $this->addElements( array($id, $email, $firstname, $lastname, $password, $submitbutton ) );
        
    }
}

?>