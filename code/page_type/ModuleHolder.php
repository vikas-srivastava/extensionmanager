<?php
/**
 * Model for the module search page.
 * 
 * @package extensionmanager
 */

class ModuleHolder extends ExtensionHolder{
	
	static $db = array(
		'AddContent' => 'HTMLText',
		);

	static $default_records = array(
		array('Title' => "Modules")
		);

	//copied from addons module 
	static $defaults = array(
		'AddContent' => "
		<h3>How do I submit a module to the SilverStripe directory?</h3>

		<p>Complete and submit the form below. </p>

		<h3>What happens after I submit my module?</h3>	

		<p>Our module reviewers at SilverStripe are notified, and they will review your submission and contact you if they have questions. Please note that we are verifying that your module will install, but we won't do a full code review.</p> 
		<p>You'll be notified when your module has been listed on the site. We try and approve new submissions quickly but please know that it typically takes at least 4 weeks for your module to appear on the SilverStripe website. If you have questions, please contact <a href=\"mailto:modules@silverstripe.org\">modules@silverstripe.org</a>.</p>

		<h3>What if I need to make changes to my module?</h3>	

		<p>Once your module is listed on the SilverStripe website, you can edit it via the same submission form </p>",
		
		);

	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab("Root.Main", new HTMLEditorField("AddContent", "Content for 'add' page"));
		return $fields;
	}
}

/**
 * Controller for the module search page.
 *
 * @package extensionmanager
 */
class ModuleHolder_Controller extends ExtensionHolder_Controller {

	static $urlhandlers = array(
		'addnew' => 'addnew',
		);	

	/**
	 * Setting up the form for module submission.
	 *
	 * @return Array .
	 */
	function addNew() {

		$this->basePage = $this->data();
		$this->addContent = array(
			'Title' => 'Submit a module',
			'Content' => $this->dataRecord->AddContent
			);
		$content = $this->addContent;
		$content['Form'] = $this->AddForm();

		return $this->customise($content)->renderWith(array('ExtensionHolder', 'Page'));
	}

	/**
	 * Show module list on page 
	 *
	 * @return Array .
	 */
	function moduleList() { 
		$modules = ExtensionData::get()->filter(array('Type' => 'Module', 'Accepted' => '1'))->sort('Name');
			return $modules ;			
	}	
	//todo showing list of all module is not permanent solution 
	//but we need more time for implementing solr or sphinx search  
}			