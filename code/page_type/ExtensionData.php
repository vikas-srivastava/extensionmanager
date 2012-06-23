<?php

/**
 * Acts as base class for stroing and handling 
 * Extensions(Module/Widget/Theme) Data .
 *
 * @package extensionmanager
 */
class ExtensionData extends DataObject {

	static $db = array(	
		//'MemberID' => 'Int',
		'Url' => 'Varchar(100)',
		'Accepted' => 'Boolean',
		'Name' => 'VarChar(50)',
		'Description' => 'VarChar(50)',
		'Version' => 'VarChar(500)',
		"Type" => "Enum('Module, Theme, Widget', 'Module')",
		'Keywords' => 'VarChar(500)',
		'Homepage' => 'VarChar(500)',
		'ReleaseTime' => 'SS_Datetime',
		'Licence' => 'VarChar(500)',
		'AuthorsInfo' => 'VarChar(500)',
		'SupportEmail' => 'VarChar(100)',
		'SupportIssues' => 'VarChar(100)',
		'SupportForum' => 'VarChar(100)',
		'SupportWiki' => 'VarChar(100)',
		'SupportIrc' => 'VarChar(50)',
		'SupportSource' => 'VarChar(100)',
		'TargetDir' => 'VarChar(100)',
		'Require' => 'VarChar(500)',
		'RequireDev' => 'VarChar(500)',
		'Conflict' => 'VarChar(500)',
		'Replace' => 'VarChar(500)',
		'Provide' => 'VarChar(500)',
		'Suggest' => 'VarChar(500)',
		'ConfigVendorDir' => 'VarChar(500)',
		'ConfigBinDir' => 'VarChar(500)',
		'Extra' => 'VarChar(500)',
		'Repositories' => 'VarChar(500)',
		'IncludePath' => 'VarChar(500)',
		'Bin' => 'VarChar(500)',
		'MinimumStability' => 'VarChar(500)',
	);	

	static $searchable_fields = array(
      'Name',
      'Type',
      'Keywords',
      'SubmittedByID' 
   	);

	static $summary_fields = array(
		'Name',
		'Type',
		'Description',
	);

	static $has_one = array(
        'SubmittedBy' => 'Member',
        'Module' => 'Module',
    );
	
} 

class ExtensionData_Controller extends Controller {
	
	public function getExtensionData() {
        $Params = $this->getURLParams();

        if(is_numeric($Params['ID']) && $ExtensionData = ExtensionData::get()->byID((int)$Params['ID']))
        {      
            return $ExtensionData;
        }
    }

    public function getAuthors($ExtensionData) {
       $AuthorsInfo = unserialize($ExtensionData->AuthorsInfo);

        return array(
            'AuthorName'=>$AuthorsInfo['0']['name'],
            'AuthorEmail'=>$AuthorsInfo['0']['email'],
            'AuthorHomePage'=>$AuthorsInfo['0']['homepage'],
            );
    }
}