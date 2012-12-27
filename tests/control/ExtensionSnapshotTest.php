<?php
/**
* @package extensionmanager
* @subpackage tests
*/
class ExtensionSnapshotTest extends SapphireTest {

	static $fixture_file = 'extensionmanager/tests/ExtensionManagerTest.yml';

	function testSaveSnapshot() {

		$obj = $this->objFromFixture('ExtensionData', 'testmodule');
		$realUrl = 'http://openbees.org/images/Demo.jpg';

		$imageId = ExtensionSnapshot::saveSnapshot($realUrl, $obj->Name);
		$image = Image::get()->byID($imageId);

		$this->assertFileExists(BASE_PATH.DIRECTORY_SEPARATOR.$image->Filename);
	}

	/**
     * @expectedException InvalidArgumentException
     */
	function testSaveSnapshotException() {

		$obj = $this->objFromFixture('ExtensionData', 'testmodule');
		$fakeUrl = 'http://openbees.org/images/FakeImage.jpg';

		ExtensionSnapshot::saveSnapshot($fakeUrl, $obj->Name);
	}
}