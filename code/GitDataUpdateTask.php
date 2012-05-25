<?php
class GitDataUpdateTask extends DailyTask {
	function process() {
		foreach (DataObject::get("JsonContent","") as $JsonContent) {
			$jsonFile = new GithubReader();
			$jsonPath = $jsonFile->cloneModule($JsonContent->$Url);
			$updateJson = $jsonFile->saveJson($JsonContent->$Url,$jsonPath);
		}
	}
}