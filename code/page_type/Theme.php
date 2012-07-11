<?php 

/**
 * Acts as base class for Detailed Theme Pages .
 *
 * @package extensionmanager
 */
class Theme extends ExtensionData {

}

class Theme_Controller extends ExtensionData_Controller {

    public function init() {
        parent::init();
        $this->type = 'Theme';
    }

    public function index() {        
        $this->redirect('themes/');
    }   
}