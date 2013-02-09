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
		'Title' => 'VarChar(100)',
		'VendorName'=> 'VarChar(100)',
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
		'URLSegment' => 'Varchar(200)'
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
		'ExtensionAuthors' => 'ExtensionAuthor',
		'Keywords' => 'ExtensionKeywords',
		);

	public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName("CategoryID");
        $field = new DropdownField('CategoryID', 'Category', ExtensionCategory::get()->map('ID', 'CategoryName'));
        $field->setEmptyString('(Select one)');
        $fields->addFieldToTab('Root.Main', $field,'Title');
        return $fields;
    }

	public function getCustomSearchContext() {
		$fields = $this->scaffoldSearchFields(array(
			'restrictFields' => array('Name','CompatibleSilverStripeVersion','Keywords.KeywordName','Category.CategoryName')
			));

		$filters = array(
			'Name' => new PartialMatchFilter('Name'),
			'CompatibleSilverStripeVersion' => new PartialMatchfilter('CompatibleSilverStripeVersion'),
			'Keywords.KeywordName' => new PartialMatchFilter('Keywords.KeywordName'),
			'Category.CategoryName' => new PartialMatchFilter('Category.CategoryName'),
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
				'To' => ExtensionAuthorController::get_authors_email($this->ID),
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

	/**
	  * ModuleHolder Page Link.
	  *
	  * @return string $modulePageLink
	  */
	public function Link(){
		$extensionPageLink = "";
		$id = $this->ID;
		if($this->URLSegment){
			$id = $this->URLSegment;
		}
		if($this->Type == 'Module'){
			$page = Page::get()->filter('ClassName','ModuleHolderPage')->first();
			$extensionPageLink = $page ? $page->Link("show/$id") : "";
		}
		if($this->Type == 'Theme'){
			$page = Page::get()->filter('ClassName','ThemeHolderPage')->first();
			$extensionPageLink = $page ? $page->Link("show/$id") : "";
		}
		if($this->Type == 'Widget'){
			$page = Page::get()->filter('ClassName','WidgetHolderPage')->first();
			$extensionPageLink = $page ? $page->Link("show/$id") : "";
		}
		return $extensionPageLink;
	}
}