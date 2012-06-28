<?php
class JsonUpdateTask extends DailyTask {
	
	function process() {
		$this->updateJson();
	}

	function updateJson() {
		$jsonFile = ExtensionPage::get();
		$count = 0;
		if ($jsonFile && !empty($jsonFile)) {
			$count = $jsonFile->Count();
			foreach ($jsonFile as $jsonFile) {
				$json = new JsonHandler();
				$jsonData = $json->cloneJson($jsonFile->Url);
				$updateJson = $json->UpdateJson($jsonFile->Url,$jsonData);               
				if($updateJson) {
					echo "{$jsonFile->Name}  is updated <br />" ;
				}
				else {
					echo  "{$jsonFile->Name}  could not updated <br />" ;
				}
			}
			echo "<br /><br /><strong>{$count} Json File processed...</strong><br />";
		} else { 
			echo 'No jsonFile found...';
		}	
	}
}

class JsonUpdateTask_Manual extends BuildTask {

	function run($request) {
		echo "Running Json Data Update - Rebuilding the Database entries of all Json Files \n\n";

		$update = new JsonUpdateTask();
		$update->process();
	}
}