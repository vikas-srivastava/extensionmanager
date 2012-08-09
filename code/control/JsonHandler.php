<?php
/**
 * All task related to json file.
 * 
 * Usage:
 * <code>
 * $json = new JsonReader();
 * $json->cloneJson($url);
 * $json->saveJson($url,$latestReleaseData);
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
	public $latestReleaseData;
	public $versionData;
	public $availableVersions;

	/**
	  * Convert a module url into json content 
	  *
	  * @param string $url
	  * @return array $data
	  */
	public function cloneJson($url) { 
		$this->url = $url ;
		$jsonData = array();

		try{	
			$config = Factory::createConfig();
			$repo = new VcsRepository(array('url' => $url,''), new NullIO(), $config);
			
			if(!isset($repo)) {
				throw new InvalidArgumentException('We are not able to parse submitted url "'
					.$url.'" Please make sure you are following our module submission Instructions');
			} 
			
			$versions =  $repo->getPackages();			
			
			if($versions) {
				$releaseDateTimeStamps = array();
				$this->versionData = $versions;
				$this->availableVersions = count($this->versionData);

				for ($i=0; $i < $this->availableVersions ; $i++) {
					array_push($releaseDateTimeStamps, date_timestamp_get($this->versionData[$i]->getReleaseDate()));
				}

				foreach ($releaseDateTimeStamps as $key => $val) {
					if ($val == max($releaseDateTimeStamps)) {
						$this->latestReleaseData = $this->versionData[$key];
					}
				}
			}
		} catch (Exception $e) {
			$jsonData['ErrorMsg'] = $e->getMessage();
		}

		$jsonData['AllRelease'] = $this->versionData;
		$jsonData['LatestRelease'] = $this->latestReleaseData;
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
		if($this->latestReleaseData->getPrettyName()) {
			list($vendorName, $moduleName) = explode("/", $this->latestReleaseData->getPrettyName());
			$ExtensionData->Name = $moduleName ; 
		}

		if($this->latestReleaseData->getDescription()) {
			$ExtensionData->Description = $this->latestReleaseData->getDescription();
		}
		
		if($this->latestReleaseData->getPrettyVersion()) {
			$ExtensionData->Version = $this->latestReleaseData->getPrettyVersion();
		}

		if($this->latestReleaseData->getType()) {
			$type = $this->latestReleaseData->getType() ;
			if(preg_match("/\bmodule\b/i", $type)){
				
				$ExtensionData->Type = 'Module';

			} elseif(preg_match("/\btheme\b/i", $type)) { 
				
				$ExtensionData->Type = 'Theme';

			} elseif(preg_match("/\bwidget\b/i", $type)) {
				
				$ExtensionData->Type = 'Widget';
			} //todo should have some action if none of type matched  

		} 

		if($this->latestReleaseData->getHomepage()) {
			$ExtensionData->Homepage = $this->latestReleaseData->getHomepage();			
		}

		if($this->latestReleaseData->getReleaseDate()) {
			$ExtensionData->ReleaseTime = $this->latestReleaseData->getReleaseDate()->format('Y-m-d H:i:s');
		}

		if($this->latestReleaseData->getLicense()) {
			$ExtensionData->Licence = $this->latestReleaseData->getLicense();
		}

		if($this->latestReleaseData->getSupport()) {
			$supportData = $this->latestReleaseData->getSupport() ;
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

		if($this->latestReleaseData->getTargetDir()) {
			$ExtensionData->TargetDir = $this->latestReleaseData->getTargetDir();
		}

		if($this->latestReleaseData->getRequires()) {
			$ExtensionData->Require = serialize($this->latestReleaseData->getRequires());
		}

		if($this->latestReleaseData->getDevRequires()) {
			$ExtensionData->RequireDev = serialize($this->latestReleaseData->getDevRequires());
		}

		if($this->latestReleaseData->getConflicts()) {
			$ExtensionData->Conflict = serialize($this->latestReleaseData->getConflicts());
		}

		if($this->latestReleaseData->getReplaces()) {
			$ExtensionData->Replace = serialize($this->latestReleaseData->getReplaces());
		}

		if($this->latestReleaseData->getProvides()) {
			$ExtensionData->Provide = serialize($this->latestReleaseData->getProvides());
		}

		if($this->latestReleaseData->getSuggests()) {
			$ExtensionData->Suggest = serialize($this->latestReleaseData->getSuggests());
		}

		if($this->latestReleaseData->getExtra()) {
			$ExtensionData->Extra = serialize($this->latestReleaseData->getExtra());
			$extra = $this->latestReleaseData->getExtra();
			if(array_key_exists('snapshot',$extra)) {
				$ExtensionData->ThumbnailID = ExtensionSnapshot::saveSnapshot($extra['snapshot'],$this->latestReleaseData->getPrettyName());
			}
		}

		if($this->latestReleaseData->getRepositories()) {
			$ExtensionData->Repositories = serialize($this->latestReleaseData->getRepositories());
		}

		if($this->latestReleaseData->getIncludePaths()) {
			$ExtensionData->IncludePath = serialize($this->latestReleaseData->getIncludePaths());
		}

		if($this->latestReleaseData->getMinimumStability()) {
			$ExtensionData->MinimumStability = $this->latestReleaseData->getMinimumStability();
		}

		$ExtensionData->write() ;

		if($this->latestReleaseData->getAuthors()) {
			ExtensionAuthorController::storeAuthorsInfo($this->latestReleaseData->getAuthors(),$ExtensionData->ID);
		}

		if($this->latestReleaseData->getKeywords()) {
			ExtensionKeywords::saveKeywords($this->latestReleaseData->getKeywords(),$ExtensionData->ID);
		}

		return $ExtensionData->ID;
	}

	/**
	  * Save Version related data of Extension 
	  *
	  * @param int $id  
	  * @return boolean
	  */
	public function saveVersionData($id) {
		
		
		for ($i=0; $i < $this->availableVersions ; $i++) { 
			$version = new ExtensionVersion();
			$version->ExtensionDataID = $id;
			$result = $this->versionDataField($version,$this->versionData[$i]);
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

		//todo add release data of each version 
		if($data->getReleaseDate()) {
			$version->ReleaseDate = $data->getReleaseDate()->format('Y-m-d H:i:s');
		}
		
		$version->write();
		return true;
	}
}