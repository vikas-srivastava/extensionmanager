<?php 
/**
 * Acts as base class for Detailed Module Pages .
 *
 * @package extensionmanager
 */
class Module extends ExtensionData {

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
        $this->redirect('modules/');
        
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
                'MetaTitle' => $ExtensionData->Name,
                'ExtensionData' => $ExtensionData,
                'SubmittedBy' => $this->getExtensionSubmittedBy($ExtensionData),
                'Keywords' => $this->getExtensionKeywords($ExtensionData),
                'AuthorsDetail'=> $this->getExtensionAuthorsInfo($ExtensionData),
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