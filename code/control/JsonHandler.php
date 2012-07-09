<?php
/**
 * All task related to json file.
 * 
 * Usage:
 * <code>
 * $json = new JsonReader();
 * $json->cloneJson($url);
 * $json->saveJson($url,$jsonData);
 * </code>
 *
 * @package extensionmanager
 */
use Composer\Config;
use Composer\IO\NullIO;
use Composer\Factory;
use Composer\Repository\VcsRepository;
use Composer\Repository\RepositoryManager;

class JsonHandler extends ContentController {
	
	public $url;
	public $jsonData;
	public $versionData;
	/**
	  * Convert a module url into json content 
	  *
	  * @param string $url
	  * @return array $data
	  */
	public function cloneJson($url) { 
		$this->url = $url ;
		
		try{	
			$config = new Config();
			$config->merge(array('config' => array('home' => '/home/vikas/.composer')));
			$repo = new VcsRepository(array('url' => $url,''), new NullIO(), $config);
			$driver = $repo->getDriver();
			if(!isset($driver)) {
				return false;
			} 
			$data = $driver->getComposerInformation($driver->getRootIdentifier());

			if($data) {
				$this->jsonData = $data;
			}	
			
			$versions =  $repo->getPackages();			
			
			if($versions) {
				$this->versionData = $versions;
			}
			
			return array(
				'Data' => $data,
				'Versions' => $versions,
				);			
		} catch (Exception $e) {
			return false;
		}
	}

	/**
	  * Save json content in database  
	  *
	  * @return boolean
	  */
	function saveJson() {
		$Json = new ExtensionData();
		$Json->SubmittedByID = Member::currentUserID();
		$Json->Url = $this->url;
		$result = $this->dataFields($Json);
		return $result ;
	}			

	/**
	  * update json content in database  
	  *
	  * @return boolean
	  */
	function updateJson() {

		$Json = ExtensionData::get()->filter(array("Url" => "$this->url"))->First();

		if($Json) {
			$result = $this->dataFields($Json);
			return $result ;
		} else {
			return Null ;
		}		
	}

	/**
	  * Save each property of json content 
	  * in corresponidng field of database  
	  *
	  * @param  object $Json 
	  * @return boolean
	  */
	function dataFields($Json) {
		if(array_key_exists('name',$this->jsonData)) {
			list($vendorName, $moduleName) = explode("/", $this->jsonData["name"]);
			$Json->Name = $moduleName ; 
		}

		if(array_key_exists('description',$this->jsonData)) {
			$Json->Description = $this->jsonData['description'];
		}
		
		if(array_key_exists('version',$this->jsonData)) {
			$Json->Version = $this->jsonData['version'];
		}

		if(array_key_exists('type',$this->jsonData)) {
			$type = $this->jsonData["type"] ;
			if(preg_match("/\bmodule\b/i", $type)){
				
				$Json->Type = 'Module';

			} elseif(preg_match("/\btheme\b/i", $type)) { 
				
				$Json->Type = 'Theme';

			} elseif(preg_match("/\bwidget\b/i", $type)) {
				
				$Json->Type = 'Widget';
			} //todo should have some action if none of type matched  

		} 

		if(array_key_exists('keywords',$this->jsonData)) {
			$Json->Keywords = serialize($this->jsonData['keywords']);
		}

		if(array_key_exists('homepage',$this->jsonData)) {
			$Json->Homepage = $this->jsonData['homepage'];			
		}

		if(array_key_exists('time',$this->jsonData)) {
			$Json->ReleaseTime = $this->jsonData['time'];
		}

		if(array_key_exists('licence',$this->jsonData)) {
			$Json->Licence = $this->jsonData['licence'];
		}

		if(array_key_exists('authors',$this->jsonData)) {
			$Json->AuthorsInfo = serialize($this->jsonData['authors']);
		}

		if(array_key_exists('support',$this->jsonData)) {
			if(array_key_exists('email',$this->jsonData['support'])) {
				$Json->SupportEmail = $this->jsonData['support']['email'];
			}
			if(array_key_exists('issues',$this->jsonData['support'])) {
				$Json->SupportIssues = $this->jsonData['support']['issues'];
			}
			if(array_key_exists('forum',$this->jsonData['support'])) {
				$Json->SupportForum = $this->jsonData['support']['forum'];
			}
			if(array_key_exists('wiki',$this->jsonData['support'])) {
				$Json->SupportWiki = $this->jsonData['support']['wiki'];
			}
			if(array_key_exists('irc',$this->jsonData['support'])) {
				$Json->SupportIrc = $this->jsonData['support']['irc'];
			}
			if(array_key_exists('source',$this->jsonData['support'])) {
				$Json->SupportSource = $this->jsonData['support']['source'];
			}			
		}

		if(array_key_exists('target-dir',$this->jsonData)) {
			$Json->TargetDir = $this->jsonData['target-dir'];
		}

		if(array_key_exists('require',$this->jsonData)) {
			$Json->Require = serialize($this->jsonData['require']);
		}

		if(array_key_exists('require-dev',$this->jsonData)) {
			$Json->RequireDev = serialize($this->jsonData['require-dev']);
		}

		if(array_key_exists('conflict',$this->jsonData)) {
			$Json->Conflict = serialize($this->jsonData['conflict']);
		}

		if(array_key_exists('replace',$this->jsonData)) {
			$Json->Replace = serialize($this->jsonData['replace']);
		}

		if(array_key_exists('provide',$this->jsonData)) {
			$Json->Provide = serialize($this->jsonData['provide']);
		}

		if(array_key_exists('suggest',$this->jsonData)) {
			$Json->Suggest = serialize($this->jsonData['suggest']);
		}

		if(array_key_exists('config',$this->jsonData)) {
			if(array_key_exists('wiki',$this->jsonData['config'])) {
				$Json->ConfigVendorDir = $this->jsonData['config']['vendor-dir'];
			}
			if(array_key_exists('irc',$this->jsonData['config'])) {
				$Json->ConfigBinDir = $this->jsonData['config']['bin-dir'];
			}
		}

		if(array_key_exists('extra',$this->jsonData)) {
			$Json->Extra = serialize($this->jsonData['extra']);
		}

		if(array_key_exists('repositories',$this->jsonData)) {
			$Json->Repositories = serialize($this->jsonData['repositories']);
		}

		if(array_key_exists('include-path',$this->jsonData)) {
			$Json->IncludePath = serialize($this->jsonData['include-path']);
		}

		if(array_key_exists('bin',$this->jsonData)) {
			$Json->Bin = serialize($this->jsonData['bin']);
		}

		if(array_key_exists('minimum-stability', $this->jsonData)) {
			$Json->MinimumStability = $this->jsonData['minimum-stability'];
		}
		$Json->write() ;
		return $Json->ID;
	}

	/**
	  * Save Version related data of Extension 
	  *
	  * @param int $id  
	  * @return boolean
	  */
	public function saveVersionData($id) {
		
		$availableVersions = count($this->versionData);
		for ($i=0; $i < $availableVersions ; $i++) { 
			$version = new ExtensionVersion();
			$version->ExtensionDataID = $id;
			$result = $this->versionDataField($version,$this->versionData[$i]);
		}
		return $result ;
	}

 	/**
	  * Update Version related data of Extension 
	  *
	  * @param int $id  
	  * @return boolean
	  */
 	//something strange happening probably wrong way to update each row ?
 	public function updateVersionData($id) { 
 		$version = ExtensionVersion::get()->filter(array('ExtensionDataID' => "$id"));
 		$availableVersions = count($this->versionData);
 		if($version) { 
 			for($i=0; $i < $availableVersions ; $i++) {
 				$result = $this->versionDataField($version[$i],$this->versionData[$i]);
 			} return $result ;
 		} else {
 			return false ;
 		}
 	}

	/**
	  * Save each version related property of json content 
	  *
	  * @param  object $version, object $Data 
	  * @return boolean
	  */
	public function versionDataField($version,$data) {
		
		if($data->getSourceType()) {
			$version->SourceType = $data->getSourceType();
		}

		if($data->getSourceUrl()) {
			$version->SourceUrl = $data->getSourceUrl();
		}
		
		if($data->getSourceReference()) {
			$version->SourceReference = $data->getSourceReference();
		}

		if($data->getDistType()) {
			$version->DistType = $data->getDistType();
		}

		if($data->getDistUrl()) {
			$version->DistUrl = $data->getDistUrl();
		}

		if($data->getDistReference()) {
			$version->DistReference = $data->getDistReference();
		}

		if($data->getDistSha1Checksum()) {
			$version->DistSha1Checksum = $data->getDistSha1Checksum();
		}

		if($data->getVersion()) {
			$version->Version = $data->getVersion();
		}

		if($data->getPrettyVersion()) {
			$version->PrettyVersion = $data->getPrettyVersion();
		}

		//todo add release data of each version 
		/*if($data->getReleaseDate()) {
			$version->ReleaseDate = $data->getReleaseDate();
		}*/
		
		$version->write();
		return true;
	}
}