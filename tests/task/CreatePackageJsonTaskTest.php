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
		try {
			$PackageJson =  new CreatePackageJsonTask_Manual();
			$PackageJson->run(null);
			$this->assertFileExist(BASE_PATH.DIRECTORY_SEPARATOR.'packages.json');
		} catch (InvalidArgumentException $expected) {
			return;
		}
		$this->fail('InvalidArgumentException expected');
	}
}