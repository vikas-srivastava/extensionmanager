<?php
class ModuleHolder extends Page {
	static $db = array(
		"AddContent" => 'HTMLText'
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

		<p>Once your module is listed on the SilverStripe website, you can edit it via the same submission form </p>"
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
class ModuleHolder_Controller extends Page_Controller {

	/**
	 * Setting up the form.
	 *
	 * @return Form .
	 */
	/*function Manage() {
		return $this->AddForm() ;
	}*/

	function manage() {
		$to = 'modules@silverstripe.org';
		
		return new ExtensionCRUD($this->data(), $to,
			// Add form content
			array(
				'Title' => 'Submit a module',
				'Content' => $this->dataRecord->AddContent
			), 
			
			// After add/edit content
			array(
				'Title' => 'Thanks for your submission',
				'Content' => "<p>You'll be notified when your module has been listed on the site. We try and approve new submissions quickly but please know that it typically takes at least 4 weeks for your module to appear on the SilverStripe website. If you have questions, please contact <a href=\"mailto:modules@silverstripe.org\">modules@silverstripe.org</a></p>"
			)
		);
	}	
}			