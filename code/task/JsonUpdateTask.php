<?php
/**
 * For Updating composer.Json data of extensions. 
 *
 * @package extensionmanager
 */

use Composer\package\Dumper\ArrayDumper;

class JsonUpdateTask extends DailyTask {
	
	function process() {
		$this->updateJson();
	}

	function updateJson() {
		$extensionData = ExtensionData::get();
		$count = 0;
		if ($extensionData && !empty($extensionData)) {
			$count = $extensionData->Count();
			
			$filename = 'packages.json';
			$repo = array('packages' => array());

			foreach ($extensionData as $extension) {
				$json = new JsonHandler();
				$jsonData = $json->cloneJson($extension->Url);
				$packages = $jsonData['AllRelease'];
				$dumper = new ArrayDumper;

				$updateJson = $json->UpdateJson();               
				if($updateJson) {
					$id = $updateJson;
					$deleteVersion = $json->deleteVersionData($id);
					if($deleteVersion){
						$saveVersion = $json->saveVersionData($id);
						if($saveVersion){
							echo "<br />$extension->Name is updated <br />" ;
						}
					}	
				}
				else {
					echo  "$extension->Name  could not updated <br />" ;
				} 

				foreach ($packages as $package) {
					$repo['packages'][$package->getPrettyName()][$package->getPrettyVersion()] = $dumper->dump($package);
				}		
			}

			if(!empty($repo)) {
				$packagesJsonData = Convert::array2json($repo);
				$packageJsonFile = fopen(BASE_PATH.DIRECTORY_SEPARATOR.$filename, 'w');
				fwrite($packageJsonFile, $packagesJsonData); 
				fclose($packageJsonFile);
				echo "<br /><br /><strong> package.json file created successfully...</strong><br />";
			} else {
				throw new InvalidArgumentException('package.json file could not be created');
			}
			echo "<br /><br /><strong>{$count} Json File processed...</strong><br />";
		} else { 
			echo 'No Extension found...';
		}	
	} 
}

/**
 * For Manually Updating composer.Json data of extensions. 
 *
 * @package extensionmanager
 */
class JsonUpdateTask_Manual extends BuildTask {

	function run($request) {
		echo "Running Json Data Update - Rebuilding the Database entries of all Json Files \n\n";
		$update = new JsonUpdateTask();
		$update->process();
	}
}