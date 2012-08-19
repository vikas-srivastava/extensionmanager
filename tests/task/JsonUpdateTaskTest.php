<?php
/**
 * @package extensionmanager
 * @subpackage tests
 */
class JsonUpdateTaskTest  extends SapphireTest {

	static $fixture_file = 'extensionmanager/tests/ExtensionManagerTest.yml';

	/**
     * @expectedException InvalidArgumentException
     */
	function testUpdateJsonWithNoExtensionDataExist() {
		$PackageJson =  new CreatePackageJsonTask_Manual();
		$PackageJson->run(null);
	}
	//todo test for more functions
}	