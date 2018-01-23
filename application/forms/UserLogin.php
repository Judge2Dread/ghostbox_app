<?php

class Application_Form_UserLogin extends Zend_Form{

    public function init(){
        /* Form Elements & Other Definitions Here ... */
		$this->setMethod('POST');
		$this->setAttrib('class', 'form-signin');
		
		$this->addElement('text', 'user_email', array(
            'required'       => true,
            'label'          => 'Email',
            'description'    => '',
            'class'          => 'form-control',
			'id'			 => 'inputEmail',
            'filters'        => array('StringTrim'),
			'placeholder'	 => 'E-mail',
			'autofocus'		 => true,
        ));
		
		$this->addElement('password', 'user_password', array(
            'required'       => true,
            'label'          => 'Passwort',
            'description'    => '',
            'class'          => 'form-control',
			'id'			 => 'inputPassword',
            'filters'        => array('StringTrim'),
			'placeholder'	 => 'Password'
        ));
		
		/* $this->addElement('checkbox', 'user_remember', array(
            'class'          => 'checkbox',
			'id'			 => '',
			'options' => array(
				'label'      			=> 'A checkbox',
				'checked_value' 		=> 'good',
				'unchecked_value' 		=> 'bad'
			)
        )); */
                
        $this->addElement('Submit', 'user_submit', array(
            'label'         => 'Login',
			'class'         => 'btn btn-logreg form-control',
        ));
		
		// remove decorators
		foreach($this->getElements() as $elem) {
			$elem->setDecorators(array(
			    array('ViewHelper'),
				array('Errors')
			));
		}
        	
        /* $this->getElement('user_nickname')->getDecorator('Description')
            ->setOption('placement', 'prepend');
        $this->getElement('user_password')->getDecorator('Description')
            ->setOption('placement', 'prepend'); */
    }
}