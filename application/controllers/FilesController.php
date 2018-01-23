<?php
class FilesController extends Zend_Controller_Action
{
    protected $_thisUser = null;
    protected $_thisUserSettings = null;
    public function init()
    {
        // check auth and get user
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $mapper = new Application_Model_Mappers_RawUser();
            $this->_thisUser = $mapper->fetchSingleById(Zend_Auth::getInstance()->getStorage()->read()->ID);
            $this->view->thisUser = $this->_thisUser;
        }
        // check auth and get user settings
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $mapper = new Application_Model_Mappers_RawUserSettings();
            $this->_thisUserSettings = $mapper->fetchSingleByUserId(Zend_Auth::getInstance()->getStorage()->read()->ID);
            $this->view->thisUserSettingers = $this->_thisUserSettings;
        }
    }
    public function indexAction()
    {
        // check auth
        // get data
        $data = $this->getRequest()->getPost();
        if (!empty($data) && isset($data['suchen'])) {
            // New Mapper
            $filemapper = new Application_Model_Mappers_RawFiles();
            // Explode Tags
            $tags = explode(" ", $data['search']);
            $mapper = new Application_Model_Mappers_RawFiles();
            $results = $mapper->fetchFilesByTag($tags);
            $resultdata = array();
            if ($results == null) {
               $resultdata = 0;
            } else {
                if (!$this->_thisUser) {
                    // Keine User angemeldet
                    // nur public Dateien
                    foreach ($results as $result) {
                        $result = $result->toArray();
                        $locationmapper = new Application_Model_Mappers_RawUserSettings();
                        $result['location'] = $locationmapper->fetchSingleByUserId($result['userid'])->getSaveLocationLocal();
                        if ($result['public'] == 1) {
                            $resultdata[] = $result;
                        }
                    }
                } else {
                    // User angemeldet
                    // nur seine Dateien
                    foreach ($results as $result) {
                        $result = $result->toArray();
                        $locationmapper = new Application_Model_Mappers_RawUserSettings();
                        $result['location'] = $locationmapper->fetchSingleByUserId($result['userid'])->getSaveLocationLocal();
                        if ($result['userid'] == $this->_thisUser->getId()) {
                            $resultdata[] = $result;
                        }
                    }
                }
            }
            $this->view->resultdata = $resultdata;
        }
        $form = new Application_Form_FilesSearch();
        $this->view->form = $form;
        $this->view->user = $this->_thisUser;
    }