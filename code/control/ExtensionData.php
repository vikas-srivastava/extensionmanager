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
		'Name' => 'VarChar(100)',
		'Description' => 'Text',
		"Type" => "Enum('Module, Theme, Widget', 'Module')",
		'DetailPageLink' => 'VarChar(100)',
		'Homepage' => 'VarChar(500)',
		'CompatibleSilverStripeVersion' => 'VarChar(20)',
		'LicenceType' => 'VarChar(500)',
		'LicenceDescription' => 'Text',
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
		'Name' => array(
			'title' => 'Name',
			'field' => 'TextField',
			'filter' => 'PartialMatchFilter',
			),
		'Type' => array(
			'title' => 'Extension Type',
			),
		'CompatibleSilverStripeVersion' => array(
			'title' => 'Compatible SilverStripe Versions',
			'field' => 'TextField',
			'filter' => 'PartialMatchfilter'
			),
		'Keywords.KeywordName' => array(
			'title' => 'Keyword',
			'field' => 'TextField',
			'filter' => 'PartialMatchFilter',
			),
		'Category.CategoryName' => array(
			'title' => 'Category',
			'field' => 'TextField',
			'filter' => 'PartialMatchFilter',
			)
		);

	static $summary_fields = array(
		'Name' => array(
			'title' => 'Name',
			),
		'Type' => array(
			'title' => 'Extension Type',
			),
		'Description' => array(
			'title' => 'Description',
			),
		'CompatibleSilverStripeVersion' => array(
			'title' => 'Compatible SilverStripe Versions',
			),
		'DetailPageLink' => array(
			'title' => 'Detail Page',
			)
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

	public function getCustomSearchContext() {
		$fields = $this->scaffoldSearchFields(array(
			'restrictFields' => array('Name','CompatibleSilverStripeVersion','Keywords.KeywordName','Category.CategoryName')
			));

		$filters = array(
			'Name' => new PartialMatchFilter('Name'),
			'CompatibleSilverStripeVersion' => new PartialMatchfilter('CompatibleSilverStripeVersion'),
			'Keyword' => new PartialMatchFilter('Keywords.KeywordName'),
			'Category' => new PartialMatchFilter('Category.CategoryName'),
			);
		return new SearchContext(
			$this->class,
			$fields,
			$filters
			);
	}

	public function onAfterWrite() {

		if(!$this->DetailPageLink) {
			$this->DetailPageLink = Director::absoluteBaseURL().strtolower($this->Type).'/show/'.$this->ID;
			$this->write();
		}

		if($this->isChanged('Accepted') && $this->Accepted) {

			$mailData = array(
				'Subject' => $this->Type." '".$this->Name."' has been Approved",
				'To' => ExtensionAuthorController::getAuthorsEmail($this->ID),
				'From' => Config::inst()->get($this->Type, 'ReviewerEmail'),
				'ExtensionType' => $this->Type,
				'ExtensionName' => $this->Name,
				'ExtensionPageUrl' => $this->DetailPageLink,
				'SubmittedBy' => $this->SubmittedBy()->Name,
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
	
	public $type, $disqus;

	static $allowed_actions = array(
		'index',
		'show',   
		);

	public function init() {
		parent::init();
		$this->disqus = file_get_contents(BASE_PATH.DIRECTORY_SEPARATOR.'extensionmanager/thirdparty/disqus.js');
	}

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
			if(Permission::check("ADMIN") || ($ExtensionData->Type == $this->type && $ExtensionData->Accepted == "1" )) {
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
    			'Keywords' => $ExtensionData->Keywords(),
    			'AuthorsDetail'=> ExtensionAuthorController::getAuthorsInformation($ExtensionData->ID),
    			'VersionData' => ExtensionVersion::getExtensionVersion($ExtensionData->ID),
    			'DownloadLink' => ExtensionVersion::getLatestVersionDistUrl($ExtensionData->ID),
    			'Category' => ExtensionCategory::getExtensionCategory($ExtensionData->CategoryID),
    			'SnapShot' => $ExtensionData->Thumbnail(),
    			'Disqus' => $this->disqus,
    			);
    		return $this->customise($Data)->renderWith(array($this->type.'_show', 'Page'));
    	}
    	else{
    		return $this->httpError(404, "Sorry that $this->type could not be found");
    	}
    } 
}