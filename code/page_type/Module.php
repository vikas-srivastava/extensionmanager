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
                'MetaTitle' => $ExtensionData->Name,
                'ExtensionName' => $this-> getExtensionName($ExtensionData),
                'URL' => $this->getExtensionUrl($ExtensionData),
                'SubmittedBy' => $this->getExtensionSubmittedBy($ExtensionData),
                'Description' => $this->getExtensionDescription($ExtensionData),
                'Version' => $this->getExtensionVersion($ExtensionData),
                'Keywords' => $this->getExtensionKeywords($ExtensionData),
                'Homepage' => $this->getExtensionHomepage($ExtensionData),
                'ReleaseTime' => $this->getExtensionReleaseTime($ExtensionData),
                'Licence' => $this->getExtensionLicence($ExtensionData),
                'AuthorsDetail'=> $this->getExtensionAuthorsInfo($ExtensionData),
                'SupportEmail' => $this->getExtensionSupportEmail($ExtensionData),
                'SupportIssues' => $this->getExtensionSupportIssues($ExtensionData),
                'SupportForum' => $this->getExtensionSupportForum($ExtensionData),
                'SupportWiki' => $this->getExtensionSupportWiki($ExtensionData),
                'SupportIrc' => $this->getExtensionSupportIrc($ExtensionData),
                'SupportSource' => $this->getExtensionSupportSource($ExtensionData)
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