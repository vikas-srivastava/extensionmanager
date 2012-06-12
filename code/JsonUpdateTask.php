<?php
class JsonUpdateTask extends DailyTask {
	
	function process() {
		$this->updateJson();
	}

	function updateJson() {
		$jsonFile = DataObject::get(
			$callerClass = 'JsonContent',
			$filter = '',
			$sort = '',
			$join = '',
			$limit = ''
			);
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
				// $json->destroy();	
			}
			echo "<br /><br /><strong>{$count} Json File processed...</strong><br />";
		} else { 
			echo 'No jsonFile found...';
		}	
	}
}

class GitDataUpdateTask_Manual extends BuildTask {

	function run($request) {
		echo "Running Git Module Update - Rebuilding the Database entries of all JsonContent \n\n";

		$update = new JsonUpdateTask();
		$update->process();
	}
}