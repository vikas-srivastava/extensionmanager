<?php
class GithubReader extends RequestHandler {

	Protected $moduleName, $moduleFolder, $url, $jsonPath , $command;

	
	function cloneModule($url) {
		
		$this->moduleName = basename($url);
		//$moduleName	=  //.git from name of module
		$this->moduleName = substr_replace($this->moduleName,"",-4) ;
		$this->moduleFolder = BASE_PATH."/assets/modules/master/";

		//clone repo on local server for reading package.json		
		exec("cd $this->moduleFolder &&  git clone $url && cd $this-moduleName && rm -rf .git") ;   	

		$this->jsonPath = Controller::join_links($this->moduleFolder,$this->moduleName, "package.json");

		return $this->jsonPath ;
	}	
 
	function saveJson($url,$jsonPath) {

		if(file_exists($jsonPath)) {

			$jsonRawContent = @file_get_contents($jsonPath);
			
			$jsonContent = Convert::json2array($jsonRawContent);
		}

		$Json = DataObject::get_one("JsonContent", "URL = '$this->url'");

		if(!$Json) { //calling from url form so save new row 

			$Json = new JsonContent();
			$Json->Url = $url;
			$Json->ModuleName = $jsonContent["name"];
			$Json->Description = $jsonContent["description"];
			$Json->Keywords = $jsonContent["keywords"][0];
			$Json->MemberID = Member::currentuserID();
			$Json->Version = $jsonContent["version"];
			$Json->Homepage = $jsonContent["homepage"];
			$Json->Author = $jsonContent["author"];
			$Json->RepositoryType = $jsonContent["repository"]["type"];
			$Json->RepositoryUrl = $jsonContent["repository"]["url"];
			$Json->BugsEmail = $jsonContent["bugs"]["email"];
			$Json->BugsUrl = $jsonContent["bugs"]["url"];
			$Json->LicensesType = $jsonContent["licenses"][0]["type"];
			$Json->LicensesUrl = $jsonContent["licenses"][0]["url"];
			$Json->Dependencies = $jsonContent["dependencies"];

			$Json->write();

			return true ;
		
		} else { 

		//calling from cron job to update row 
			DB::query("UPDATE JsonContent SET 
				Url = $url,
				ModuleName = $jsonContent['name'],
				Description = $jsonContent['description'],
				Keywords = $jsonContent['keywords'][0],
				MemberID = Member::currentuserID(),
				Version = $jsonContent['version'],
				Homepage = $jsonContent['homepage'],
				Author = $jsonContent['author'],
				RepositoryType = $jsonContent['repository']['type'],
				RepositoryUrl = $jsonContent['repository']['url'],
				BugsEmail = $jsonContent['bugs']['email'],
				BugsUrl = $jsonContent['bugs']['url'],
				LicensesType = $jsonContent['licenses'][0]['type'],
				LicensesUrl = $jsonContent['licenses'][0]['url'],
				Dependencies = $jsonContent['dependencies']");
			
		}

	}
}