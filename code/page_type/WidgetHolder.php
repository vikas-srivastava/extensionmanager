<?php
class WidgetHolder extends page {

	static $db = array(	
	);
	
	static $has_many = array(
		'Widgets' => 'Widget'
	);	
}

/**
 * Controller for the module holder page.
 *
 * @package extensionmanager
 */
class WidgetHolder_Controller extends Page_Controller {

	static $allowed_actions = array(
        'WidgetUrlForm'
    );

	/**
	 * Setting up the form.
	 *
	 * @return Form .
	 */
	function WidgetUrlForm() {
		define('SPAN', '<span class="required">*</span>');
		$fields = new FieldList(
			new TextField ('Url', 'Please Submit Read-Only Url of your Widget Repository'. SPAN) 
		);
		$actions = new FieldList(
			new FormAction('submitUrl', 'Submit')
		);
		$validator = new RequiredFields('URL');
		return new Form($this, 'WidgetUrlForm', $fields, $actions, $validator);
	}

	/**
	 * The form handler.
	 */
	public function submitUrl($data, $form) {
		$url = $data['Url'];
		$path = '/assets/Extension_Data/widgets';
		if(empty($url) || substr($url,0, 4) != "http") {
			$form->sessionMessage(_t('WidgetHolder.BADURL','Please enter a valid URL'), 'Error');
			return $this->redirectBack();
		}
		
		$json = new JsonHandler();
		$jsonData = $json->cloneJson($url,$path);
		
		if($jsonData) {
			$saveJson = $json->saveJson($url,$jsonData);
		} else {
   				$form->sessionMessage(_t('WidgetHolder.BADURL','Sorry we could not find any composer.json file on given url.'), 'Error');
		}			
		
		if($saveJson) {
			$form->sessionMessage(_t('WidgetHolder.THANKSFORSUBMITTING','Thank you for your submission'),'good');
		}
		
		$this->redirectBack();
	}

}			