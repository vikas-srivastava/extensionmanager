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
			$count = $extensionData->Count();
			foreach ($extensionData as $extension) {
				$json = new JsonHandler();
				$jsonData = $json->cloneJson($extension->Url);
				$updateJson = $json->UpdateJson();               
				if($updateJson) {
					$id = $updateJson;
					$deleteVersion = $json->deleteVersionData($id);
					if($deleteVersion){
						$saveVersion = $json->saveVersionData($id);
						if($saveVersion){
						echo "<br />$$extension->Name is updated <br />" ;
						}
					}	
				}
				else {
					echo  "$extension->Name  could not updated <br />" ;
				}
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