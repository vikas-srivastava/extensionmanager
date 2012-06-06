<?php
class GitReader extends RequestHandler {

	Protected $moduleName, $moduleFolder, $url, $jsonPath  ;

	
	function cloneModule($url) {
		
		$this->moduleName = basename($url);
		//$moduleName	=  //.git from name of module
		$this->moduleName = substr_replace($this->moduleName,"",-4) ;
		$this->moduleFolder = BASE_PATH."/assets/modules/master/";

		
		//clone repo on local server for reading composer.json		
		exec("cd $this->moduleFolder && rm -r -f  $this->moduleName && git clone $url && chmod 0755 -R $this-moduleName && cd $this-moduleName && rm -rf .git") ;   	

		$this->jsonPath = Controller::join_links($this->moduleFolder,$this->moduleName, "composer.json");

		return $this->jsonPath ;
	}	

	function saveJson($url,$jsonPath) {

		$where = "Url = '$url'";

		if(file_exists($jsonPath)) {

			$jsonRawContent = @file_get_contents($jsonPath);
			
			$jsonContent = Convert::json2array($jsonRawContent);
		}

		$Json = DataObject::get_one("JsonContent", $where );

		
		if(!$Json) { //calling from url form so save new row 

			$Json = new JsonContent();
			$Json->Url = $url;
			$Json->MemberID = Member::currentuserID();
			$Json->ModuleName = $jsonContent["name"];
			$Json->Description = $jsonContent["description"];
			$Json->Type = $jsonContent["type"];
			
			foreach ($jsonContent["keywords"] as $key => $value) {
				$Json->Keywords .= $value.',';
			}
			
			$Json->Homepage = $jsonContent["homepage"];

			if(array_key_exists("license",$jsonContent)) {	
				$Json->LicenseType = $jsonContent["license"];
			}

			if(array_key_exists("version",$jsonContent)) {
				$Json->Version = $jsonContent["version"];
			}			

			$Json->write();

			return true ;

		} else { 

			$Json->Url = $url;
			$Json->ModuleName = $jsonContent["name"];
			$Json->Description = $jsonContent["description"];
			$Json->Type = $jsonContent["type"];
			$Json->Keywords = $jsonContent["keywords"][0];
			$Json->Homepage = $jsonContent["homepage"];

			if(array_key_exists("license",$jsonContent)) {	
				$Json->LicenseType = $jsonContent["license"];
			}

			if(array_key_exists("version",$jsonContent)) {
				$Json->Version = $jsonContent["version"];
			}			

			if($Json->write()) {
				return true ;
			}


		}
	}
}	