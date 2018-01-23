<?php
class Application_Form_UserDashboard extends Zend_Form{
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

        

        // search
        $search = new Zend_Form_Element_Text('user_search');
        $search->setLabel('Search');
        $search->setRequired(true);
        $search->setAttribs(array('class' => 'form-control', 'placeholder' => 'Input Tag here', 'required' => ''));
        $search->setValue($this->_user->getFirstname());
        
       
        
        //Submit Button
        $submitbutton = new Zend_Form_Element_Button('Save');
        $submitbutton->setAttribs(array('type' => 'submit', 'class' => 'btn btn-logreg form-control'));
        $submitbutton->setValue('Update');
       
       //  $this->addElements( array($id, $email, $firstname, $lastname, $password, $submitbutton ) );
        
    }
}

?>