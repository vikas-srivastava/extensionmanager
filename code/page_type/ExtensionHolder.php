<?php
/**
 * This class will serve as base class for 
 * all the ExtensionHolder classes (module/widget/theme)
 * contains extension submission forms and their handler. 
 *
 * @package extensionmanager
 */
class ExtensionHolder extends Page {

}
class ExtensionHolder_Controller extends Page_Controller {

	public $basePage, $baseLink, $addContent, $afterEditContent;
	public $reviewerEmail; //todo will use for sending mail after extension submission
	
	/**
	 * Setting up the form.
	 *
	 * @return Form .
	 */
	public function AddForm() {

		if(!Member::currentUser()) return Security::permissionFailure();
		
		$fields = new FieldList(
			new TextField ('Url', 'Please Submit Read-Only Url of your Extension Repository') 
			);
		$actions = new FieldList(
			new FormAction('submitUrl', 'Submit')
			);
		$validator = new RequiredFields('URL');
		return new Form($this, 'AddForm', $fields, $actions, $validator);
	}

	/**
	 * The form handler.
	 */
	public function submitUrl($data, $form) {
		$url = $data['Url'];
		if(empty($url) || substr($url,0, 4) != "http" || (preg_match('{//.+@}', $url))) {
			$form->sessionMessage(_t('ExtensionHolder.BADURL','Please enter a valid URL'), 'bad');
			return $this->redirectBack();
		}
		
		$json = new JsonHandler();
		$jsonData = $json->cloneJson($url);
		
		if($jsonData['Data']) {
			if($this->isNewExtension($url)) {
				$saveJson = $json->saveJson();
				if($saveJson) {
					//need review: is it right way to get last written dataobject
					$id = $saveJson;
					$saveVersion = $json->saveVersionData($id);
					if($saveVersion){
						$form->sessionMessage(_t('ExtensionHolder.THANKSFORSUBMITTING','Thank you for your submission'),'good');
						return $this->redirectBack();
					}
				} else {
					$form->sessionMessage(_t('ExtensionHolder.PROBLEMINSAVING','We are unable to save module info, Please Re-check format of you composer.json file. '),'bad');
					return $this->redirectBack();
				}
			} else {
				$updateJson = $json->updateJson();
				if($updateJson) {
					$id = $updateJson;
					$updateVersion = $json->updateVersionData($id);
					if($updateVersion) {
						$form->sessionMessage(_t('ExtensionHolder.THANKSFORUPDATING','Thank you for Updating Your Module'),'good');
						return $this->redirectBack();
					}
				} else {
					$form->sessionMessage(_t('ExtensionHolder.PROBLEMINUPDATING','We are unable to UPDATE module info, Please Re-check format of you composer.json file. '),'bad');
					return $this->redirectBack();
				}
			}
		} else {
			$form->sessionMessage(_t('ExtensionHolder.NOJSON','Sorry we could not find any composer.json file on given url . Please read our extension Submission Guide for more details and submit url again'), 'bad');
			return $this->redirectBack();
		}			
	}

	/**
	  * Check if submitted module is new or old  
	  *
	  * @param string $url  
	  * @return boolean
	  */
	public function isNewExtension($url) {
		$Json = ExtensionData::get()->filter(array("Url" => "$url"))->First();
		if(!$Json) {
			return true;
		} else {
			return false;
		}
	}
}