<?php
/**
* @package extensionmanager
* @subpackage tests
*/
class CreatePackageJsonTaskTest extends SapphireTest {
	/**
     * @expectedException InvalidArgumentException
     */
	function testCreatePackageJson() {
		
			$PackageJson =  new CreatePackageJsonTask_Manual();
			$PackageJson->run(null);
			$this->assertFileExist(BASE_PATH.DIRECTORY_SEPARATOR.'packages.json');
	}
}