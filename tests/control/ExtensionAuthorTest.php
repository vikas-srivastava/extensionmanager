<?php
/**
* @package extensionmanager
* @subpackage tests
*/
class ExtensionAuthorTest extends SapphireTest {

	static $fixture_file = 'extensionmanager/tests/ExtensionManagerTest.yml';

	function testStoreAuthorsInfo(){

		$authorsRawData = array(
			'0' => array(
				'name' => 'Test User',
				'email' => 'testuser@test.com',
				'homepage' => 'www.test.com',
				'role' => 'test-Developer'
				)
			);

		$obj = $this->objFromFixture('ExtensionData', 'testmodule');
		$extensionId = $obj->ID;
		$ExtensionAuthorController = new ExtensionAuthorController();
		$extensionAuthorsId = $ExtensionAuthorController->storeAuthorsInfo($authorsRawData,$extensionId);
		$extensionAuthor = ExtensionAuthor::get()->byID($extensionAuthorsId['0']);

		$this->assertEquals($extensionAuthor->Email , 'testuser@test.com');
		$this->assertEquals($extensionAuthor->Name , 'Test User');
		$this->assertEquals($extensionAuthor->HomePage , 'www.test.com');
		$this->assertEquals($extensionAuthor->Role , 'test-Developer');
	}

	/**
     * @expectedException InvalidArgumentException
     */
	function testStoreAuthorsInfoException() {

		$authorsRawData = array(
			'0' => array(
				'homepage' => 'www.test.com',
				'role' => 'test-Developer'
				)
			);

		$obj = $this->objFromFixture('ExtensionData', 'testmodule');
		$extensionId = $obj->ID;
		$ExtensionAuthorController = new ExtensionAuthorController();
		$memberId = $ExtensionAuthorController->storeAuthorsInfo($authorsRawData,$extensionId);
	}
}