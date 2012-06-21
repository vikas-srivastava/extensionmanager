<?php 
class ModuleController extends Page_Controller {
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
        
    public function getExtensionData()
    {
        $Params = $this->getURLParams();
         
        if(is_numeric($Params['ID']) && $ExtensionData =ExtensionData::get()->byID((int)$Params['ID']))
        {      
            return $ExtensionData;
        }
    }
     
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
            return $this->httpError(404, 'Sorry that Module could not be found');
        }
    }
    
}