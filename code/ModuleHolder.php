<?php
class ModuleHolder extends page {

	static $db = array(
		
	);
	
	static $has_many = array(
		'Modules' => 'Module'
	);	
}

class ModuleHolder_Controller extends Page_Controller {

	static $allowed_actions = array(
        'ModuleUrlForm'
    );

	function ModuleUrlForm() {

		define('SPAN', '<span class="required">*</span>');

		$fields = new FieldList(
			new TextField ('Url', 'Please Submit Read-Only Url of your Git Repository'. SPAN) 
		);

		$actions = new FieldList(
			new FormAction('submitUrl', 'Submit')
		);

		$validator = new RequiredFields('URL');

		return new Form($this, 'ModuleUrlForm', $fields, $actions, $validator);

	}

	
	public function submitUrl($data, $form) {
		$url = $data['Url'];
		
		if(empty($url) || substr($url,0, 6) != "git://") {
			$form->sessionMessage(_t('ModuleHolder.BADURL','Please enter a valid URL valid git read only url'), 'Error');
			return $this->redirectBack();
		}
		

		$jsonFile = new GitReader();
		$jsonPath = $jsonFile->cloneModule($url);
		
		if(!file_exists($jsonPath)) {
			$form->sessionMessage(_t('ModuleHolder.NOJSON','Unable to read json file '),'Er');
			return $this->redirectBack();
		}	
				
		$saveJson = $jsonFile->saveJson($url,$jsonPath);

		if($saveJson) {
			$form->sessionMessage(_t('ModuleManager.THANKSFORSUBMITTING','Thank you for your submission'),'good');
		}
		$this->redirectBack();
	}

}			