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
	
	/**
	  * Get one Extension data from database using
	  * Url ID
	  *
	  * @return array
	  */
	public function getExtensionData() {
        $Params = $this->getURLParams();

        if(is_numeric($Params['ID']) && $ExtensionData = ExtensionData::get()->byID((int)$Params['ID']))
        {      
            return $ExtensionData;
        }
    }
    
    /**
	  * Get one Extension Name
	  *
	  *	@param ExtensionData
	  * @return striUrl  */
    static function getExtensionName($ExtensionData) {
    	return $ExtensionData->Name;
    }

    /**
	  * Get URL of extenson Repository
	  *
	  *	@param ExtensionData
	  * @return string
	  */
   	static function getExtensionUrl($ExtensionData) {
    	return $ExtensionData->Url;
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
	  * Check if extension is accepted
	  *
	  *	@param ExtensionData
	  * @return boolean
	  */
    static function isExtensionAccepted($ExtensionData) {
    	return $ExtensionData->Accepted;
    }

    /**
	  * Get Extension Description
	  *
	  *	@param ExtensionData
	  * @return string
	  */
    static function getExtensionDescription($ExtensionData) {
    	return $ExtensionData->Description;
    }

    /**
	  * Get Version of Extension
	  *
	  *	@param ExtensionData
	  * @return string
	  */
    static function getExtensionVersion($ExtensionData) {
    	return $ExtensionData->Version;
    }

    /**
	  * Get Type of extension
	  *
	  *	@param ExtensionData
	  * @return string
	  */
    static function getExtensionType($ExtensionData) {
    	return $ExtensionData->Type;
    }

    /**
	  * Get Keywords of extension
	  *
	  *	@param ExtensionData
	  * @return string
	  */
    static function getExtensionKeywords($ExtensionData) {
    	$keywords = unserialize($ExtensionData->Keywords);
    	$values = implode(" ", $keywords);
    	return $values ;
    }

    /**
	  * Get Homepage of Extension
	  *
	  *	@param ExtensionData
	  * @return string
	  */
    static function getExtensionHomepage($ExtensionData) {
    	return $ExtensionData->Homepage;
    }

    /**
	  * Get Time of release
	  *
	  *	@param ExtensionData
	  * @return datatime
	  */
    static function getExtensionReleaseTime($ExtensionData) {
    	return $ExtensionData->ReleaseTime;
    }

    /**
	  * Get Licence
	  *
	  *	@param ExtensionData
	  * @return string
	  */
    static function getExtensionLicence($ExtensionData) {
    	return $ExtensionData->Licence;
    }

    /**
	  * Get Extension Author Info
	  *
	  * @param ExtensionData
	  * @return array
	  */
    static function getExtensionAuthorsInfo($ExtensionData) {
       $AuthorsInfo = unserialize($ExtensionData->AuthorsInfo);

        return array(
            
            'AuthorName'=>$AuthorsInfo['0']['name'],
            'AuthorEmail'=>$AuthorsInfo['0']['email'],
            'AuthorHomePage'=>$AuthorsInfo['0']['homepage'],
            //'AuthorRole' => $AuthorsInfo['0']['role']            
            );
        //todo now it can display only one author info .. not checking if value is set
    }

    /**
	  * Get Support email
	  *
	  *	@param ExtensionData
	  * @return string
	  */
    static function getExtensionSupportEmail($ExtensionData) {
    	return $ExtensionData->SupportEmail;
    }

    /**
	  * Get Url of issue list
	  *
	  *	@param ExtensionData
	  * @return string
	  */
    static function getExtensionSupportIssues($ExtensionData) {
    	return $ExtensionData->SupportIssues;
    }

    /**
	  * Get Url of support forum
	  *
	  *	@param ExtensionData
	  * @return string
	  */
    static function getExtensionSupportForum($ExtensionData) {
    	return $ExtensionData->SupportForum;
    }

    /**
	  * Get Url of support wiki page
	  *
	  *	@param ExtensionData
	  * @return string
	  */
    static function getExtensionSupportWiki($ExtensionData) {
    	return $ExtensionData->SupportWiki;
    }

    /**
	  * Get IRC channel of extension
	  *
	  *	@param ExtensionData
	  * @return string
	  */
    static function getExtensionSupportIrc($ExtensionData) {
    	return $ExtensionData->SupportIrc;
    }

    /**
	  * Get Support source URL
	  *
	  *	@param ExtensionData
	  * @return string
	  */
    static function getExtensionSupportSource($ExtensionData) {
    	return $ExtensionData->SupportSource;
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