<?php 

/**
 * Acts as base class for Detailed Module Pages .
 *
 * @package extensionmanager
 */
class Module extends ExtensionData {

    static $has_one = array (
        'ExtensionData' => 'ExtensionData',
        );

}

class Module_Controller extends ExtensionData_Controller {

    static $allowed_actions = array(
        'index',
        'show',
        
        );

    public function init() {
        parent::init();
    }

    public function index() {        
        return array();
    }

    /**
      * Show module data   
      *
      * @return array
      */
    function show() {      
        if($ExtensionData = $this->getExtensionData())
        {   
            $Data = array(
                'ExtensionData' => $ExtensionData,
                'MetaTitle' => $ExtensionData->Name,
                'AuthorsDetail'=> $this->getAuthorsInfo($ExtensionData),
                'URL' => $this->getUrl($ExtensionData),
                'SubmittedBy' => $this->getSubmittedBy($ExtensionData),
                );  
            return $this->customise($Data)->renderWith(array('Module_show', 'Page'));
            //todo .. not rendering header and navigation templates from theme 
        }
        else
        {
            return $this->httpError(404, 'Sorry that Module could not be found');
        }
    }
}