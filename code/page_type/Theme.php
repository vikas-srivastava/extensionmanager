<?php 

/**
 * Acts as base class for Detailed Theme Pages .
 *
 * @package extensionmanager
 */
class Theme extends ExtensionData {

}

class Theme_Controller extends ExtensionData_Controller {

    static $allowed_actions = array(
        'index',
        'show',
        
        );

    public function init() {
        parent::init();
    }

    public function index() {        
        $this->redirect('themes/');
        
    }   

    /**
      * Show module data   
      *
      * @return array
      */
    function show() { 
        $type = "Theme" ;
        if($ExtensionData = $this->getExtensionData($type))
        {   
            $Data = array(
                'MetaTitle' => $ExtensionData->Name,
                'ExtensionData' => $ExtensionData,
                'SubmittedBy' => $this->getExtensionSubmittedBy($ExtensionData),
                'Keywords' => $this->getExtensionKeywords($ExtensionData),
                'AuthorsDetail'=> $this->getExtensionAuthorsInfo($ExtensionData),
            );  
            return $this->customise($Data)->renderWith(array('Theme_show', 'Page'));
            //todo .. not rendering header and navigation templates from theme 
        }
        else
        {
            return $this->httpError(404, 'Sorry that Theme could not be found');
        }
    }
}