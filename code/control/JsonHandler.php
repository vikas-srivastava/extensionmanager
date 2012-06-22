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
use Composer\Repository\VcsRepository;
use Composer\Downloader\TransportException;
use Composer\Repository\Vcs\VcsDriverInterface;
use Composer\Package\Version\VersionParser;
use Composer\Package\Loader\ArrayLoader;
use Composer\IO\IOInterface;
use Composer\Repository\RepositoryManager;
use Composer\Factory;

class JsonHandler extends RequestHandler {
	
	private $url;

	private $jsonData;
	/**
	  * Convert a module url into json content 
	  *
	  * @param string $url
	  * @return array $data
	  */
	function cloneJson($url) { 
		$this->url = $url ;
		
		try{	
			$config = Factory::createConfig();
			$repo = new VcsRepository(array('url' => $url), new NullIO(), $config);
			//$packages = $repo->getPackages();	
			$driver = $repo->getDriver();
			if(!isset($driver)) {
				return ;
			} 
			$data = $driver->getComposerInformation($driver->getRootIdentifier());
			return $data;
			
		} catch (Exception $e) {
			return ;
		}
	}

	/**
	  * Save json content in database  
	  *
	  * @param string $url, Array $jsonData 
	  * @return boolean
	  */
	function saveJson($url,$jsonData) {
		$Json = new ExtensionData();
		$Json->SubmittedByID = Member::currentUserID();
		$Json->Url = $url;
		$result = $this->dataFields($Json, $jsonData);
		return $result ;
		}			

	/**
	  * update json content in database  
	  *
	  * @param string $url, Array $jsonData 
	  * @return boolean
	  */
	function updateJson($url, $jsonData) {
		$Json = ExtensionData::get()->filter(array("Url" => "$url"))->First();
		if($Json) {
			$result = $this->dataFields($Json, $jsonData);
			return $result ;
		} else {
			return false ;
		}		
	}

	/**
	  * Save each property of json content 
	  * in corresponidng field of database  
	  *
	  * @param string $url, Array $jsonData 
	  * @return boolean
	  */
	function dataFields($Json, $jsonData) {
		if(array_key_exists('name',$jsonData)) {
			list($vendorName, $moduleName) = explode("/", $jsonData["name"]);
			$Json->Name = $moduleName ; 
		}

		if(array_key_exists('description',$jsonData)) {
			$Json->Description = $jsonData['description'];
		}
		
		if(array_key_exists('version',$jsonData)) {
			$Json->Version = $jsonData['version'];
		}

		if(array_key_exists('type',$jsonData)) {
			$type = $jsonData["type"] ;
			if(preg_match("/\bmodule\b/i", $type)){
				
				$Json->Type = 'Module';

			} elseif(preg_match("/\btheme\b/i", $type)) { 
				
				$Json->Type = 'Theme';

			} elseif(preg_match("/\bwidget\b/i", $type)) {
				
				$Json->Type = 'Widget';
			} //todo should have some action if none of type matched  

		} 

		if(array_key_exists('keywords',$jsonData)) {
			$Json->Keywords = serialize($jsonData['keywords']);
		}

		if(array_key_exists('homepage',$jsonData)) {
			$Json->Homepage = $jsonData['homepage'];			
		}

		if(array_key_exists('time',$jsonData)) {
			$Json->ReleaseTime = $jsonData['time'];
		}

		if(array_key_exists('licence',$jsonData)) {
			$Json->Licence = $jsonData['licence'];
		}

		if(array_key_exists('authors',$jsonData)) {
			$Json->AuthorsInfo = serialize($jsonData['authors']);
		}

		if(array_key_exists('support',$jsonData)) {
			if(array_key_exists('email',$jsonData['support'])) {
				$Json->SupportEmail = $jsonData['support']['email'];
			}
			if(array_key_exists('issues',$jsonData['support'])) {
				$Json->SupportIssues = $jsonData['support']['issues'];
			}
			if(array_key_exists('forum',$jsonData['support'])) {
				$Json->SupportForum = $jsonData['support']['forum'];
			}
			if(array_key_exists('wiki',$jsonData['support'])) {
				$Json->SupportWiki = $jsonData['support']['wiki'];
			}
			if(array_key_exists('irc',$jsonData['support'])) {
				$Json->SupportIrc = $jsonData['support']['irc'];
			}
			if(array_key_exists('source',$jsonData['support'])) {
				$Json->SupportSource = $jsonData['support']['source'];
			}			
		}

		if(array_key_exists('target-dir',$jsonData)) {
			$Json->TargetDir = $jsonData['target-dir'];
		}

		if(array_key_exists('require',$jsonData)) {
			$Json->Require = serialize($jsonData['require']);
		}

		if(array_key_exists('require-dev',$jsonData)) {
			$Json->RequireDev = serialize($jsonData['require-dev']);
		}

		if(array_key_exists('conflict',$jsonData)) {
			$Json->Conflict = serialize($jsonData['conflict']);
		}

		if(array_key_exists('replace',$jsonData)) {
			$Json->Replace = serialize($jsonData['replace']);
		}

		if(array_key_exists('provide',$jsonData)) {
			$Json->Provide = serialize($jsonData['provide']);
		}

		if(array_key_exists('suggest',$jsonData)) {
			$Json->Suggest = serialize($jsonData['suggest']);
		}

		if(array_key_exists('config',$jsonData)) {
			if(array_key_exists('wiki',$jsonData['config'])) {
				$Json->ConfigVendorDir = $jsonData['config']['vendor-dir'];
			}
			if(array_key_exists('irc',$jsonData['config'])) {
				$Json->ConfigBinDir = $jsonData['config']['bin-dir'];
			}
		}

		if(array_key_exists('extra',$jsonData)) {
			$Json->Extra = serialize($jsonData['extra']);
		}

		if(array_key_exists('repositories',$jsonData)) {
			$Json->Repositories = serialize($jsonData['repositories']);
		}


		if(array_key_exists('include-path',$jsonData)) {
			$Json->IncludePath = serialize($jsonData['include-path']);
		}

		if(array_key_exists('bin',$jsonData)) {
			$Json->Bin = serialize($jsonData['bin']);
		}

		if(array_key_exists('minimum-stability', $jsonData)) {
			$Json->MinimumStability = $jsonData['minimum-stability'];
		}

		$Json->write();
		return true ;
	}

}   