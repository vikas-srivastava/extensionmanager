<?php
/**
 * Task for creating new package.json after every 15 Minutes. 
 *
 * @package extensionmanager
 */

use Composer\package\Dumper\ArrayDumper;

class CreatePackageJsonTask extends QuarterHourlyTask {
	
	function process() {
		$this->CreatePackageJson();
	}

	function CreatePackageJson() {
		$extensionData = ExtensionData::get();
		$count = 0;
		if ($extensionData && !empty($extensionData)) {
			$count = $extensionData->Count();

			$filename = 'packages.json';
			$repo = array('packages' => array());

			foreach ($extensionData as $extension) {
				// Include only Approved extensions
				if($extension->Accepted == '1') {
					$json = new JsonHandler($extension->Url);
					$jsonData = $json->cloneJson();
					$packages = $jsonData['AllRelease'];
					$dumper = new ArrayDumper;
					foreach ($packages as $package) {
						$repo['packages'][$package->getPrettyName()][$package->getPrettyVersion()] = $dumper->dump($package);
					}
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
		}
	}	
}

/**
 * For Manually Updating packages.json file. 
 *
 * @package extensionmanager
 */
class CreatePackageJsonTask_Manual extends BuildTask {

	function run($request) {
		echo "Running Package.json Update task - Recreating package.json file\n\n";
		$update = new CreatePackageJsonTask();
		$update->process();
	}
}