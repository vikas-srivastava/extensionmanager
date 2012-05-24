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
			new TextField ('Url', 'Please Submit Read-Only Url of your GitHub Repository'. SPAN) 
		);

		$actions = new FieldList(
			new FormAction('submitUrl', 'Submit')
		);

		$validator = new RequiredFields('URL');

		return new Form($this, 'ModuleUrlForm', $fields, $actions, $validator);

	}

	
	public function submitUrl($data, $form) {
		$url = $data['Url'];
		
		$moduleName = basename($data['Url']);
		$moduleName	= substr_replace($moduleName,"",-4); //.git from name of module
		if(empty($url) || substr($url,0, 16) != "git://github.com") {
			$form->sessionMessage(_t('ModuleHolder.BADURL','Please enter a valid URL valid github read only url'), 'Error');
			return $this->redirectBack();
		}

		
		$moduleFolder = BASE_PATH."/assets/modules/master/";
		
		//clone repo on local server for reading package.json		
		$command = "cd $moduleFolder &&  git clone $url && cd $moduleName && rm -rf .git";
		exec($command) ;   	
		
		$jsonPath = Controller::join_links($moduleFolder,$moduleName, "package.json");
		
		if(file_exists($jsonPath)) {

			$jsonRawContent = @file_get_contents($jsonPath);
			
			if(!$jsonRawContent) {
			$form->sessionMessage(_t('ModuleHolder.NOJSON','Unable to read json file '));
			return $this->redirectBack();
		}

			$jsonContent = Convert::json2array($jsonRawContent);

		}

		$submission = new ModuleUrlSubmission($data);
		$form->saveInto($submission);
		
		//adding every field of json into corresponding colum of database
		//storing one by one is not a good method need to improve !
					
		$submission->Url = $data['Url'];
		$submission->ModuleName = $jsonContent["name"];
		$submission->Description = $jsonContent["description"];
		$submission->Keywords = $jsonContent["keywords"][0];
		$submission->MemberID = Member::currentuserID();
		$submission->Version = $jsonContent["version"];
		$submission->Homepage = $jsonContent["homepage"];
		$submission->Author = $jsonContent["author"];
		$submission->RepositoryType = $jsonContent["repository"]["type"];
		$submission->RepositoryUrl = $jsonContent["repository"]["url"];
		$submission->BugsEmail = $jsonContent["bugs"]["email"];
		$submission->BugsUrl = $jsonContent["bugs"]["url"];
		$submission->LicensesType = $jsonContent["licenses"][0]["type"];
		$submission->LicensesUrl = $jsonContent["licenses"][0]["url"];
		$submission->Dependencies = $jsonContent["dependencies"];
			
		$submission->write();
		Director::redirect($this->Link("?success=1"));
		//$this->redirectBack();
	}

	Public function Success()
    {
        return isset($_REQUEST['success']) && $_REQUEST['success'] == "1";
    }

    Public function SubmitText() {

    	return "Your Form Submitted Successfully , Thank You For Your Contribution";
    }

}			