<?php
class ModuleHolder extends page {

	static $db = array(
		
	);
		
	
	static $has_many = array(
		'Modules' => 'Module'
		);

	
	
}

class ModuleHolder_Controller extends Page_Controller {

	function ModuleUrlForm() {

		define('SPAN', '<span class="required">*</span>');

		$fields = new FieldList(
			new TextField ('Url', 'Url of Module Repositery'. SPAN) 
		);

		$actions = new FieldList(
			new FormAction('submitUrl', 'Submit')
		);

		$validator = new RequiredFields('URL');

		return new Form($this, 'ModuleUrlForm', $fields, $actions, $validator);

	}

	function submitUrl($data, $form) {
		$submission = new ModuleUrlSubmission();
		$form->saveInto($submission);
		$submission->MemberID = Member::currentuserID();
		$submission->write();
		$this->redirectBack();

	}
	
}
