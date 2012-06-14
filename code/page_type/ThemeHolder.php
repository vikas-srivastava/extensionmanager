<?php
class ThemeHolder extends page {

	static $db = array(	
	);
	
	static $has_many = array(
		'Modules' => 'Module'
	);	
}

/**
 * Controller for the module holder page.
 *
 * @package extensionmanager
 */
class ThemeHolder_Controller extends Page_Controller {

	static $allowed_actions = array(
        'ThemeUrlForm'
    );

	/**
	 * Setting up the form.
	 *
	 * @return Form .
	 */
	function ThemeUrlForm() {
		define('SPAN', '<span class="required">*</span>');
		$fields = new FieldList(
			new TextField ('Url', 'Please Submit Read-Only Url of your Theme Repository'. SPAN) 
		);
		$actions = new FieldList(
			new FormAction('submitUrl', 'Submit')
		);
		$validator = new RequiredFields('URL');
		return new Form($this, 'ThemeUrlForm', $fields, $actions, $validator);
	}

	/**
	 * The form handler.
	 */
	public function submitUrl($data, $form) {
		$url = $data['Url'];
		$path = '/assets/Extension_Data/themes';
		if(empty($url) || substr($url,0, 4) != "http") {
			$form->sessionMessage(_t('ThemeHolder.BADURL','Please enter a valid URL'), 'Error');
			return $this->redirectBack();
		}
		
		$json = new JsonHandler();
		$jsonData = $json->cloneJson($url);
		
		if($jsonData) {
			$saveJson = $json->saveJson($url,$jsonData);
		} else {
   				$form->sessionMessage(_t('ThemeHolder.BADURL','Sorry we could not find any composer.json file on given url.'), 'Error');
		}			
		
		if($saveJson) {
			$form->sessionMessage(_t('ThemeHolder.THANKSFORSUBMITTING','Thank you for your submission'),'good');
		}
		
		$this->redirectBack();
	}

}			