<?php
/**
 * All task related to json file.
 * 
 * Usage:
 * <code>
 * $json = new JsonReader();
 * $json->cloneJson($url);
 * $json->saveJson($url,$latestReleasePackage);
 * </code>
 *
 * @package extensionmanager
 */
use Composer\Config;
use Composer\IO\NullIO;
use Composer\Factory;
use Composer\Repository\VcsRepository;
use Composer\Repository\RepositoryManager;
use Composer\package\Dumper\ArrayDumper;
use Composer\Json\JsonFile;

class JsonHandler extends Controller {
	
	public $url;
	public $latestReleasePackage;
	public $packages;
	public $availableVersions;
	public $repo;
	public $errorInConstructer;
	public $packageName;

	public function __construct($url) {
		$this->url = $url;
		$config = Factory::createConfig();
		$this->repo = new VcsRepository(array('url' => $url,''), new NullIO(), $config);
		
	}

	/**
	  * Convert a module url into json content 
	  *
	  * @param string $url
	  * @return array $data
	  */
	public function cloneJson() { 
		$jsonData = array();
		try{
			$this->packages = $this->repo->getPackages();

			foreach ($this->packages as $package) {

				$this->packageName = $package->getPrettyName();

				if (!isset($this->packageName)){
					throw new InvalidArgumentException("The package name was not found in the composer.json at '"
						.$this->url."' in '". $package->getPrettyVersion()."' ");
				}

				if (!preg_match('{^[a-z0-9]([_.-]?[a-z0-9]+)*/[a-z0-9]([_.-]?[a-z0-9]+)*$}i', $this->packageName)) {
					throw new InvalidArgumentException(
						"The package name '{$this->packageName}' is invalid, it should have a vendor name,
						a forward slash, and a package name. The vendor and package name can be words separated by -, . or _.
						The complete name should match '[a-z0-9]([_.-]?[a-z0-9]+)*/[a-z0-9]([_.-]?[a-z0-9]+)*' at "
						.$this->url."' in '". $package->getPrettyVersion()."' ");
				}

				if (preg_match('{[A-Z]}', $this->packageName)) {
					$suggestName = preg_replace('{(?:([a-z])([A-Z])|([A-Z])([A-Z][a-z]))}', '\\1\\3-\\2\\4', $this->packageName);
					$suggestName = strtolower($suggestName);

					throw new InvalidArgumentException(
						"The package name '{$this->packageName}' is invalid,
						it should not contain uppercase characters. We suggest using '{$suggestName}' instead. at '"
						.$this->url."' in '". $package->getPrettyVersion()."' ");
				}
			}

			$this->latestReleasePackage = $this->repo->findPackage($this->packageName,'9999999-dev');

		} catch (Exception $e) {
			$jsonData['ErrorMsg'] = $e->getMessage();
			return $jsonData;
		}

		$jsonData['AllRelease'] = $this->packages;
		$jsonData['LatestRelease'] = $this->latestReleasePackage;
		return $jsonData;		
	}

	/**
	  * Save json content in database  
	  *
	  * @return boolean
	  */
	function saveJson() {
		$ExtensionData = new ExtensionData();
		$ExtensionData->SubmittedByID = Member::currentUserID();
		$ExtensionData->Url = $this->url;
		$result = $this->dataFields($ExtensionData);
		return $result ;
	}			

	/**
	  * update json content in database  
	  *
	  * @return boolean
	  */
	function updateJson() {

		$ExtensionData = ExtensionData::get()->filter(array("Url" => $this->url))->First();

		if($ExtensionData) {
			$result = $this->dataFields($ExtensionData);
			return $result ;
		} else {
			return Null ;
		}		
	}

	/**
	  * Save each property of json content 
	  * in corresponidng field of database  
	  *
	  * @param  object $ExtensionData 
	  * @return boolean
	  */
	function dataFields($ExtensionData) {
		$saveDataFields = array();
		try{
			if($this->latestReleasePackage->getPrettyName()) {
				list($vendorName, $moduleName) = explode("/", $this->latestReleasePackage->getPrettyName());
				$ExtensionData->Name = $moduleName;
			} else {
				throw new InvalidArgumentException("We could not find Name field in composer.json at'"
					.$this->url."' ");
			}

			if($this->latestReleasePackage->getDescription()) {
				$ExtensionData->Description = $this->latestReleasePackage->getDescription();
			} else {
				throw new InvalidArgumentException("We could not find Description field in composer.json at'"
					.$this->url."' ");
			}

			if($this->latestReleasePackage->getPrettyVersion()) {
				$ExtensionData->Version = $this->latestReleasePackage->getPrettyVersion();
			}

			if($this->latestReleasePackage->getType()) {
				$type = $this->latestReleasePackage->getType() ;
				if(preg_match("/\bmodule\b/i", $type)){

					$ExtensionData->Type = 'Module';

				} elseif(preg_match("/\btheme\b/i", $type)) {

					$ExtensionData->Type = 'Theme';

				} elseif(preg_match("/\bwidget\b/i", $type)) {

					$ExtensionData->Type = 'Widget';
				} else {
					throw new InvalidArgumentException("We could not find 'Type' field in composer.json at'"
						.$this->url."' ");
				}
			}

			if($this->latestReleasePackage->getHomepage()) {
				$ExtensionData->Homepage = $this->latestReleasePackage->getHomepage();
			}

			if($this->latestReleasePackage->getReleaseDate()) {
				$ExtensionData->ReleaseTime = $this->latestReleasePackage->getReleaseDate()->format('Y-m-d H:i:s');
			}

			if($this->latestReleasePackage->getLicense()) {
				$ExtensionData->Licence = $this->latestReleasePackage->getLicense();
			}

			if($this->latestReleasePackage->getSupport()) {
				$supportData = $this->latestReleasePackage->getSupport() ;
				if(array_key_exists('email',$supportData)) {
					$ExtensionData->SupportEmail = $supportData['email'];
				}
				if(array_key_exists('issues',$supportData)) {
					$ExtensionData->SupportIssues = $supportData['issues'];
				}
				if(array_key_exists('forum',$supportData)) {
					$ExtensionData->SupportForum = $supportData['forum'];
				}
				if(array_key_exists('wiki',$supportData)) {
					$ExtensionData->SupportWiki = $supportData['wiki'];
				}
				if(array_key_exists('irc',$supportData)) {
					$ExtensionData->SupportIrc = $supportData['irc'];
				}
				if(array_key_exists('source',$supportData)) {
					$ExtensionData->SupportSource = $supportData['source'];
				}
			}

			if($this->latestReleasePackage->getTargetDir()) {
				$ExtensionData->TargetDir = $this->latestReleasePackage->getTargetDir();
			}

			if($this->latestReleasePackage->getRequires()) {
				$requires = $this->latestReleasePackage->getRequires();
				$allRequirePackage = array();

				foreach($requires as $requirePackage) {
					$allRequirePackage[$requirePackage->getTarget()] = $requirePackage->getPrettyConstraint();

					if($requirePackage->getTarget() == 'silverstripe/framework') {
						$ExtensionData->CompatibleSilverStripeVersion = $requirePackage->getPrettyConstraint();
					}
				}
				Debug::show($allRequirePackage);
				$ExtensionData->Require = serialize($allRequirePackage);
			} else {
				throw new InvalidArgumentException("We could not find 'require' field in composer.json at'"
					.$this->url."' ");
			}

			if($this->latestReleasePackage->getDevRequires()) {
				$ExtensionData->RequireDev = serialize($this->latestReleasePackage->getDevRequires());
			}

			if($this->latestReleasePackage->getConflicts()) {
				$ExtensionData->Conflict = serialize($this->latestReleasePackage->getConflicts());
			}

			if($this->latestReleasePackage->getReplaces()) {
				$ExtensionData->Replace = serialize($this->latestReleasePackage->getReplaces());
			}

			if($this->latestReleasePackage->getProvides()) {
				$ExtensionData->Provide = serialize($this->latestReleasePackage->getProvides());
			}

			if($this->latestReleasePackage->getSuggests()) {
				$ExtensionData->Suggest = serialize($this->latestReleasePackage->getSuggests());
			}

			if($this->latestReleasePackage->getExtra()) {
				$ExtensionData->Extra = serialize($this->latestReleasePackage->getExtra());
				$extra = $this->latestReleasePackage->getExtra();
				if(array_key_exists('snapshot',$extra)) {
					$ExtensionData->ThumbnailID = ExtensionSnapshot::saveSnapshot($extra['snapshot'],$this->latestReleasePackage->getPrettyName());
				} else {
					throw new InvalidArgumentException("We could not find SnapShot url field in composer.json at'"
						.$this->url."' ");
				}
			}

			if($this->latestReleasePackage->getRepositories()) {
				$ExtensionData->Repositories = serialize($this->latestReleasePackage->getRepositories());
			}

			if($this->latestReleasePackage->getIncludePaths()) {
				$ExtensionData->IncludePath = serialize($this->latestReleasePackage->getIncludePaths());
			}

			if($this->latestReleasePackage->getMinimumStability()) {
				$ExtensionData->MinimumStability = $this->latestReleasePackage->getMinimumStability();
			}

			if($this->latestReleasePackage->getAuthors()) {
				ExtensionAuthorController::storeAuthorsInfo($this->latestReleasePackage->getAuthors(),$ExtensionData->ID);
			} else {
				throw new InvalidArgumentException("We could not find Author Info field in composer.json at'"
					.$this->url."' ");
			}

			if($this->latestReleasePackage->getKeywords()) {
				ExtensionKeywords::saveKeywords($this->latestReleasePackage->getKeywords(),$ExtensionData->ID);
			} else {
				throw new InvalidArgumentException("We could not find Keywords field in composer.json at'"
					.$this->url."' ");
			}

		} catch(Exception $e){
			$saveDataFields['ErrorMsg'] = $e->getMessage();
			return $saveDataFields;
		}

		$ExtensionData->write();
		$saveDataFields['ExtensionID'] = $ExtensionData->ID;
		return $saveDataFields;
	}

	/**
	  * Save Version related data of Extension 
	  *
	  * @param int $id  
	  * @return boolean
	  */
	public function saveVersionData($id) {
		
		foreach ($this->packages as $package) {
			$version = new ExtensionVersion();
			$version->ExtensionDataID = $id;
			$result = $this->versionDataField($version, $package);
		}

		return $result ;
	}

	/**
	  * Delete old version of extension  
	  *
	  * @param  int $id 
	  * @return boolean
	  */
	public function deleteVersionData($id){
		return ExtensionVersion::get()->filter('ExtensionDataID', $id)->removeAll();
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

		if($data->getReleaseDate()) {
			$version->ReleaseDate = $data->getReleaseDate()->format('Y-m-d H:i:s');
		}
		
		if($data->getRequires()) {
			$requires = $this->latestReleasePackage->getRequires();

			foreach($requires as $requirePackage) {
				if($requirePackage->getTarget() == 'silverstripe/framework') {
					$version->CompatibleSilverStripeVersion = $requirePackage->getPrettyConstraint();
				}
			}
		} else {
			throw new InvalidArgumentException("We could not find 'require' field in composer.json at'"
				.$this->url."' ");
		}

		$version->write();
		return true;
	}
}