<?php 

/**
 * Acts as base class for Detailed Widget Pages .
 *
 * @package extensionmanager
 */
class Widget extends ExtensionData {

}

class Widget_Controller extends ExtensionData_Controller {

    static $allowed_actions = array(
        'index',
        'show',
        
        );

    public function init() {
        parent::init();
    }

    public function index() {        
        $this->redirect('widgets/');
        
    }   

    /**
      * Show module data   
      *
      * @return array
      */
    function show() { 
        $type = "Widget" ;
        if($ExtensionData = $this->getExtensionData($type))
        {   
            $Data = array(
                'MetaTitle' => $ExtensionData->Name,
                'ExtensionData' => $ExtensionData,
                'SubmittedBy' => $this->getExtensionSubmittedBy($ExtensionData),
                'Keywords' => $this->getExtensionKeywords($ExtensionData),
                'AuthorsDetail'=> $this->getExtensionAuthorsInfo($ExtensionData),
            );  
            return $this->customise($Data)->renderWith(array('Widget_show', 'Page'));
            //todo .. not rendering header and navigation templates from theme 
        }
        else
        {
            return $this->httpError(404, 'Sorry that Theme could not be found');
        }
    }
}