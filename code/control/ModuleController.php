<?php 
class ModuleController extends Page_Controller {
	static $allowed_actions = array(
        'index',
        'register',
        'editprofile',
        'show',
        
    );
     
    public function init() {
        parent::init();
        // Requirements, etc. here
    }
     
    public function index() {
        // Code for the index action here
        
        return array();
    }
        
    //Get the current staffMember from the URL, if any
    public function getExtensionData()
    {
        $Params = $this->getURLParams();
         
        if(is_numeric($Params['ID']) && $ExtensionData =ExtensionData::get()->byID((int)$Params['ID']))
        {      
            return $ExtensionData;
        }
    }
     
    //Displays the StaffMember detail page, using StaffPage_show.ss template
    function show()
    {      
        if($ExtensionData = $this->getExtensionData())
        {
            $Data = array(
                'ExtensionData' => $ExtensionData
            );
             
            //return our $Data array to use on the page
            return $this->Customise($Data);
        }
        else
        {
            //Staff member not found
            return $this->httpError(404, 'Sorry that Module could not be found');
        }
    }
    
}