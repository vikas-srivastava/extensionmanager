<?php
class GitDataUpdateTask extends DailyTask {
	
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
				$json = new GithubReader();
				$jsonPath = $json->cloneModule($jsonFile->Url);
				$updateJson = $json->saveJson($jsonFile->Url,$jsonPath);               
				if($updateJson) {
					echo "{$jsonFile->ModuleName}  is updated <br />" ;
				}	
			}
			echo "<br /><br /><strong>{$count} jsonFile processed...</strong><br />";
		} else { 
			echo 'No jsonFile found...';
		}	
	}
}

class GitDataUpdateTask_Manual extends BuildTask {

	function run($request) {
		echo "Running Git Module Update - Rebuilding the Database entries of all JsonContent \n\n";

		$update = new GitDataUpdateTask();
		$update->process();
	}
}