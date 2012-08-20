<?php
/**
* @package extensionmanager
* @subpackage tests
*/
class CreatePackageJsonTaskTest extends SapphireTest {
	/*
	 * Test for CreatePackageJson function
	 */
	function testCreatePackageJson() {
		
			$PackageJson =  new CreatePackageJsonTask_Manual();
			$PackageJson->run(null);
			$this->assertFileExist(BASE_PATH.DIRECTORY_SEPARATOR.'packages.json');
	}
}