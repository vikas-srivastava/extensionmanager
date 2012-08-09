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
		'Thumbnail' => 'Image',
		);

	static $has_many = array(
		'ExtensionVersions' => 'ExtensionVersion',
		);

	static $belongs_many_many = array(
		'ExtensionAuthors' => 'Member',
		'Keywords' => 'ExtensionKeywords',
		);

	public function onAfterWrite() {
		if($this->isChanged('Accepted') && $this->Accepted) {
	
			$mailData = array(
				'Subject' => $this->Type." '".$this->Name."' has been Approved",
				'To' => ExtensionAuthorController::getAuthorsEmail($this->ID),
				'From' => Config::inst()->get($this->Type, 'ReviewerEmail'),
				'ExtensionType' => $this->Type,
				'ExtensionName' => $this->Name,
				'ExtensionPageUrl' => Director::absoluteBaseURL().'module/show/'.$this->ID,
				'SubmittedBy' => ExtensionData::get()->byID(1)->SubmittedBy()->Name,
				);
			$this->sendMailtoAuthors($mailData);
		}
		parent::onAfterWrite();
	}

	/**
	  * Sending mail after extension is approved.
	  *
	  * @param array $mailData
	  */
	private function sendMailtoAuthors($mailData) {
		$From = $mailData['From'] ;
		$To = $mailData['To'] ;
		$Subject = $mailData['Subject'];
		$email = new Email($From, $To, $Subject);
		$email->setTemplate('ExtensionApproved');
		$email->populateTemplate($mailData);
		$email->send();
	}
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
      * Show module data   
      *
      * @return array
      */
    function show() { 

    	if($ExtensionData = $this->getExtensionData($this->type)) {   
    		$Data = array(
    			'MetaTitle' => $ExtensionData->Name,
    			'ExtensionData' => $ExtensionData,
    			'SubmittedBy' => $ExtensionData->SubmittedBy()->Name,
    			'Keywords' => ExtensionKeywords::getExtensionKeywords($ExtensionData->ID),
    			'AuthorsDetail'=> ExtensionAuthorController::getAuthorsInformation($ExtensionData->ID),
    			'VersionData' => ExtensionVersion::getExtensionVersion($ExtensionData->ID),
    			'DownloadLink' => ExtensionVersion::getLatestVersionDistUrl($ExtensionData->ID),
    			'Category' => ExtensionCategory::getExtensionCategory($ExtensionData->CategoryID),
    			'SnapShot' => ExtensionSnapshot::getSnapshot($ExtensionData->ThumbnailID),
    			);  
    		return $this->customise($Data)->renderWith(array($this->type.'_show', 'Page'));
    	}
    	else{
    		return $this->httpError(404, "Sorry that $this->type could not be found");
    	}
    } 
}