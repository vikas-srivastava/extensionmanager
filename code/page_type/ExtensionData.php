<?php

/**
 * Acts as base class for stroing and handling 
 * Extensions(Module/Widget/Theme) Data .
 *
 * @package extensionmanager
 */
class ExtensionData extends DataObject {

	static $db = array(	
		'Url' => 'Varchar(100)',
		'Accepted' => 'Boolean',
		'Name' => 'VarChar(50)',
		'Description' => 'VarChar(50)',
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
	);

static $has_many = array(
	'ExtesnsionVersion' => 'ExtesnsionVersion',
	);

} 

class ExtensionData_Controller extends ContentController {
	
	/**
	  * Get one Extension data from database using
	  * Url ID
	  *
	  * @return array
	  */
	public function getExtensionData($type) {
		$Params = $this->getURLParams();
		
		if(is_numeric($Params['ID']) && $ExtensionData = ExtensionData::get()->byID((int)$Params['ID']))
		{  
			if($ExtensionData->Type == $type && $ExtensionData->Accepted == "1" ) {
				return $ExtensionData;
			}
		}
	}
	
    /**
	  * Get Name of submiited by Member
	  *
	  *	@param ExtensionData
	  * @return string
	  */
    static function getExtensionSubmittedBy($ExtensionData) {
    	$id = $ExtensionData->SubmittedByID;
    	$member = Member::get()->byID($id);
    	return $member->FirstName.' '.$member->Lastname;
    }

    /**
	  * Get Keywords of extension
	  *
	  *	@param ExtensionData
	  * @return string
	  */
    static function getExtensionKeywords($ExtensionData) {
    	$keywords = unserialize($ExtensionData->Keywords);
    	$values = implode(", ", $keywords);
    	return $values ;
    }

    /**
	  * Get Extension Author Info
	  *
	  * @param ExtensionData
	  * @return array
	  */
    static function getExtensionAuthorsInfo($ExtensionData) {
    	$AuthorsInfo = unserialize($ExtensionData->AuthorsInfo);
    	
    	$AuthorsData = array();

    	if(array_key_exists('name', $AuthorsInfo['0'])) {
    		$AuthorsData['AuthorName'] = $AuthorsInfo['0']['name'];
    	}

    	if(array_key_exists('email', $AuthorsInfo['0'])) {
    		$AuthorsData['AuthorEmail'] = $AuthorsInfo['0']['email'];
    	}

    	if(array_key_exists('homepage', $AuthorsInfo['0'])) {
    		$AuthorsData['AuthorHomePage'] = $AuthorsInfo['0']['homepage'];
    	}

    	if(array_key_exists('role', $AuthorsInfo['0'])) {
    		$AuthorsData['AuthorRole'] = $AuthorsInfo['0']['role'];
    	}

    	return $AuthorsData  ;
    	
        //todo now it can display only one author info .. not checking if value is set
    }

    /**
	  * Get URL's of other repository of this extension
	  *
	  *	@param ExtensionData
	  * @return string
	  */
    static function getExtensionRepositories($ExtensionData) {
    	$Repositories = unserialize($ExtensionData->TargetDir);	
    }
}