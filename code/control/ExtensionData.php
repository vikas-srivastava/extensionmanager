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
		'Homepage' => 'VarChar(500)',
		'Licence' => 'VarChar(500)',
		'Version' => 'Varchar(30)',
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
		'SubmittedByID' 
		);

	static $summary_fields = array(
		'Name',
		'Type',
		'Description',
		);

	static $has_one = array(
		'SubmittedBy' => 'Member',
		'Category' => 'ExtensionCategory',
		);

	static $has_many = array(
		'ExtensionVersions' => 'ExtensionVersion',
		);

	static $belongs_many_many = array(
		'ExtensionAuthors' => 'Member',
		'Keywords' => 'ExtensionKewords',
		);
} 

class ExtensionData_Controller extends ContentController {
	
	public $type;

	static $allowed_actions = array(
		'index',
		'show',   
		);

	/**
	  * Get one Extension data from database using
	  * Url ID
	  *
	  * @param string $type
	  * @return array
	  */
	public function getExtensionData() {
		$Params = $this->getURLParams();
		
		if(is_numeric($Params['ID']) && $ExtensionData = ExtensionData::get()->byID((int)$Params['ID'])) {  
			if($ExtensionData->Type == $this->type && $ExtensionData->Accepted == "1" ) {
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
    static function getExtensionSubmittedBy($submittedByID) {
    	$member = Member::get()->byID($submittedByID);
    	return $member->FirstName.' '.$member->Lastname;
    }

    /**
	  * Get Keywords of extension
	  *
	  *	@param ExtensionData
	  * @return array
	  */
    static function getExtensionKeywords($extensionId) {
    	return ExtensionKeywords::get()->leftJoin("ExtensionKeywords_Extension", "\"ExtensionKeywords_Extension\".\"ExtensionDataID\" = $extensionId ");
    	
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
    static function getExtensionRepositories($extensionData) {
    	$Repositories = unserialize($extensionData->TargetDir);	
    }

    /**
	  * Get Category Name of Extension
	  *
	  *	@param extensionData
	  * @return string
	  */
    static function getExtensionCategory($categoryID) {
    	$category = ExtensionCategory::get()->byID($categoryID);
    	if($category) {
    		return $category->CategoryName;
    	}	
    }

    /**
      * Show module data   
      *
      * @return array
      */
    function show() { 

    	if($ExtensionData = $this->getExtensionData($this->type)) {   
    		$Data = array(
    			'MetaTitle' => $ExtensionData->Name,
    			'ExtensionData' => $ExtensionData,
    			'SubmittedBy' => $this->getExtensionSubmittedBy($ExtensionData->SubmittedByID),
    			'Keywords' => $this->getExtensionKeywords($ExtensionData->ID),
    			'AuthorsDetail'=> ExtensionAuthor::getAuthorsInformation($ExtensionData->ID),
    			'VersionData' => ExtensionVersion::getExtensionVersion($ExtensionData->ID),
    			'DownloadLink' => ExtensionVersion::getLatestVersionDistUrl($ExtensionData->ID),
    			'Category' =>$this->getExtensionCategory($ExtensionData->CategoryID),
    			);  
    		return $this->customise($Data)->renderWith(array($this->type.'_show', 'Page'));
    	}
    	else{
    		return $this->httpError(404, "Sorry that $this->type could not be found");
    	}
    }
}