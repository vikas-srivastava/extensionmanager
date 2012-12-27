<?php
/**
 * Acts as base class for Detailed Module Pages .
 *
 * @package extensionmanager
 */
class Module extends ExtensionData {

}

class Module_Controller extends ExtensionData_Controller {

    public function init() {
        parent::init();
        $this->type = 'Module';
    }

    public function index() {
        $this->redirect('modules/');
    }
}