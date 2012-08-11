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

	public $addContent, $afterEditContent;
	public $extensionName, $mailData, $extensionType;
	
	/**
	 * Setting up the form.
	 *
	 * @return Form .
	 */
	public function AddForm() {

		if(!Member::currentUser()) return Security::permissionFailure();
		
		$fields = new FieldList(
			new TextField ('Url', "Please Submit 'HTTP' Url of your Extension Repository") 
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
		
		if($jsonData['LatestRelease']) {
			if($this->isNewExtension($url)) {
				$saveJson = $json->saveJson();
				if($saveJson) {
					$id = $saveJson;
					$saveVersion = $json->saveVersionData($id);
					if($saveVersion){
						$this->extensionType = ExtensionData::get()->byID($id)->Type;
						$this->extensionName = ExtensionData::get()->byID($id)->Name;
						
						$this->mailData = array(
							'ExtensionType' => $this->extensionType,
							'ExtensionName' => $this->extensionName,
							'SubmittedByName' => Member::currentUser()->Name,
							'SubmittedByEmail' => Member::currentUser()->Email,
							'ReviewAtUrl' => Director::absoluteBaseURL().'admin/extensions/ExtensionData/EditForm/field/ExtensionData/item/'.$id.'/edit',
							'DetailPageLink' => Director::absoluteBaseURL().strtolower($this->extensionType).'/show/'.$id,
							'Subject' => 'New '.$this->extensionType." '".$this->extensionName."' ".' Submitted',
							);

						$this->sendMailtoAdmin();

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
					$deleteVersion = $json->deleteVersionData($id);
					if($deleteVersion){
						$saveVersion = $json->saveVersionData($id);
						if($saveVersion){
							$this->extensionType = ExtensionData::get()->byID($id)->Type;
							$this->extensionName = ExtensionData::get()->byID($id)->Name;

							$this->mailData = array(
								'ExtensionType' => $this->extensionType,
								'ExtensionName' => $this->extensionName,
								'SubmittedByName' => Member::currentUser()->Name,
								'SubmittedByEmail' => Member::currentUser()->Email,
								'ReviewAtUrl' => Director::absoluteBaseURL().'admin/extensions/ExtensionData/EditForm/field/ExtensionData/item/'.$id.'/edit',
								'DetailPageLink' => Director::absoluteBaseURL().strtolower($this->extensionType).'/show/'.$id,
								'Subject' => $this->extensionType." '".$this->extensionName."' ".' Updated',
								);

							$this->sendMailtoAdmin();

							$form->sessionMessage(_t('ExtensionHolder.THANKSFORUPDATING','Thank you for Updating you extension'),'good');
							return $this->redirectBack();
						}
					} else {
						$form->sessionMessage(_t('ExtensionHolder.PROBLEMINSAVING','Something went wrong we are not able to save versions of submitted extension '),'bad');
						return $this->redirectBack();
					}
				} else {
					$form->sessionMessage(_t('ExtensionHolder.PROBLEMINUPDATING','We are unable to UPDATE module info, Please Re-check format of you composer.json file. '),'bad');
					return $this->redirectBack();
				}
			}
		} else {
			$form->sessionMessage(_t('ExtensionHolder.NOJSON',"We had problems parsing your composer.json file, the parser reports: {$jsonData['ErrorMsg']} Please read our extension Submission Guide for more details and submit url again"), 'bad');
			return $this->redirectBack();
		}	
	}

	/**
	  * Check if submitted module is new or old  
	  *
	  * @param string $url  
	  * @return boolean
	  */
	private function isNewExtension($url) {
		$Json = ExtensionData::get()->filter(array("Url" => "$url"))->First();
		if(!$Json) {
			return true;
		} else {
			return false;
		}
	}

	/**
	  * Sending mail after extension submission/update.
	  *
	  */
	private function sendMailtoAdmin() {
		$From = $this->mailData['SubmittedByEmail'] ;
		$To = Config::inst()->get($this->mailData['ExtensionType'], 'ReviewerEmail');
		$Subject = $this->mailData['Subject'];
		$email = new Email($From, $To, $Subject);
		$email->setTemplate('ExtensionSubmitted');
		$email->populateTemplate($this->mailData);
		$email->send();
	}
}