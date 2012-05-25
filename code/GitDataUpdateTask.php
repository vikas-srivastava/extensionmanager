<?php
class GitDataUpdateTask extends DailyTask {
	function process() {

		$where = '' ;
		foreach (DataObject::get("JsonContent") as $module) {
			$jsonFile = new GithubReader();
			$jsonPath = $jsonFile->cloneModule($module->$Url);
			$updateJson = $jsonFile->saveJson($module->$Url,$jsonPath);
		}
	}
}