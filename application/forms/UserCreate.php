<?php

class Application_Form_UserCreate extends Zend_Form{

    public function init(){
        /* Form Elements & Other Definitions Here ... */
		$this->setMethod('POST');
		$this->setAttrib('class', 'form-signin');

       // Firstname
        $firstname = new Zend_Form_Element_Text('user_firstname');
        $firstname->setLabel('Firstname*');
        $firstname->setRequired(true);
        $firstname->setAttribs(array('class' => 'form-control', 'placeholder' => 'Firstname', 'required' => ''));
        
        // lastname
        $lastname = new Zend_Form_Element_Text('user_lastname');
        $lastname->setLabel('Lastname*');
        $lastname->setRequired(true);
        $lastname->setAttribs(array('class' => 'form-control', 'placeholder' => 'Lastname', 'required' => ''));
        // email
        $email = new Zend_Form_Element_Text('user_email');
        $email->setLabel('Email*');
        $email->setRequired(true);
        $email->setAttribs(array('class' => 'form-control', 'placeholder' => 'Email', 'required' => ''));
        // password
        $password = new Zend_Form_Element_password('user_password');
        $password->setLabel('Password*');
        $password->setRequired(true);
        $password->setAttribs(array('class' => 'form-control', 'placeholder' => 'Password', 'required' => ''));
        
        //Submit Button
        $submitbutton = new Zend_Form_Element_Button('Sign_up');
        $submitbutton->setValue('Register');
        $submitbutton->setAttribs(array('type' => 'submit', 'class' => 'btn btn-logreg form-control'));
        
       
		
		// remove decorators
		foreach($this->getElements() as $elem) {
			$elem->setDecorators(array(
			    array('ViewHelper'),
				array('Errors')
			));
		}
        
        $this->addElements( array( $firstname, $lastname, $email, $password, $submitbutton ) );
        	
        /* $this->getElement('user_nickname')->getDecorator('Description')
            ->setOption('placement', 'prepend');
        $this->getElement('user_password')->getDecorator('Description')
            ->setOption('placement', 'prepend'); */
    }
}