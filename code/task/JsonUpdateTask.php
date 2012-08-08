<?php
/**
 * For Updating composer.Json data of extensions. 
 *
 * @package extensionmanager
 */
class JsonUpdateTask extends DailyTask {
	
	function process() {
		$this->updateJson();
	}

	function updateJson() {
		$extensionData = ExtensionData::get();
		$count = 0;
		if ($extensionData && !empty($extensionData)) {
			$count = 0 ;
			
			foreach ($extensionData as $extension) {
				// Include only Approved extensions
				if($extension->Accepted == '1') {
					$json = new JsonHandler();
					$jsonData = $json->cloneJson($extension->Url);
					$updateJson = $json->UpdateJson();
					if($updateJson) {
						$id = $updateJson;
						$deleteVersion = $json->deleteVersionData($id);
						if($deleteVersion){
							$saveVersion = $json->saveVersionData($id);
							if($saveVersion){
								echo "<br>$extension->Name is updated <br>" ;
							}
						}
					}
					else {
						throw new InvalidArgumentException("$extension->Name  could not updated <br />");
					}
					$count++ ;
				}
			}
			echo "<br><br><strong>{$count} Repositories processed...</strong><br>";
		} else { 
			throw new InvalidArgumentException('No Extension found...');
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