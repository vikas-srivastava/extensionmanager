<?php
/**
 * Model for the widget search page.
 * 
 * @package extensionmanager
 */
class WidgetHolder extends ExtensionHolder {
	static $db = array(
		'AddContent' => 'HTMLText',
		);

	static $default_records = array(
		array('Title' => "Widgets")
		);

	//copied from addons module 
	static $defaults = array(
		'AddContent' => "
		<h3>How do I submit a Widget to the SilverStripe directory?</h3>

		<p>Complete and submit the form below. </p>

		<h3>What happens after I submit my Widget?</h3>	

		<p>Our Widget reviewers at SilverStripe are notified, and they will review your submission and contact you if they have questions. Please note that we are verifying that your Widget will install, but we won't do a full code review.</p> 
		<p>You'll be notified when your Widget has been listed on the site. We try and approve new submissions quickly but please know that it typically takes at least 4 weeks for your Widget to appear on the SilverStripe website. If you have questions, please contact <a href=\"mailto:Widgets@silverstripe.org\">Widgets@silverstripe.org</a>.</p>

		<h3>What if I need to make changes to my Widget?</h3>	

		<p>Once your Widget is listed on the SilverStripe website, you can edit it via the same submission form </p>",
		
		);

	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab("Root.Main", new HTMLEditorField("AddContent", "Content for 'add' page"));
		return $fields;
	}
}

/**
 * Controller for the widget search page.
 *
 * @package extensionmanager
 */
class WidgetHolder_Controller extends ExtensionHolder_Controller {

	static $urlhandlers = array(
		'addnew' => 'addnew',
		);	

	/**
	 * Setting up the form for widget submission.
	 *
	 * @return Array .
	 */
	function addNew() {

		$this->basePage = $this->data();
		$this->addContent = array(
			'Title' => 'Submit a Widget',
			'Content' => $this->dataRecord->AddContent
			);
		$this->reviewerEmail = Config::inst()->get('Widget', 'ReviewerEmail');
		$content = $this->addContent;
		$content['Form'] = $this->AddForm();

		return $this->customise($content)->renderWith(array('ExtensionHolder', 'Page'));
	}

	/**
	 * Show widget list on page 
	 *
	 * @return Array .
	 */
	function widgetList() { 
		$modules = ExtensionData::get()->filter(array('Type' => 'Widget','Accepted' => '1'))->sort('Name');
			return $modules ;			
	}	
	//todo showing list of all widget is not permanent solution 
	//but we need more time for implementing solr or sphinx search  
}			