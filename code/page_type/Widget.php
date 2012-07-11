<?php 

/**
 * Acts as base class for Detailed Widget Pages .
 *
 * @package extensionmanager
 */
class Widget extends ExtensionData {

}

class Widget_Controller extends ExtensionData_Controller {

    public function init() {
        parent::init();
        $this->type = 'Widget';
    }

    public function index() {        
        $this->redirect('widgets/');    
    }
}