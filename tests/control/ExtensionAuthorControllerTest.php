<?php
/**
* @package extensionmanager
* @subpackage tests
*/
class ExtensionAuthorControllerTest extends SapphireTest {

	static $fixture_file = 'extensionmanager/tests/ExtensionManagerTest.yml';

	function testStoreAuthorsInfo(){

		$authorsRawData = array(
			'0' => array(
				'name' => 'TestUser',
				'email' => 'testuser@test.com',
				'homepage' => 'www.test.com',
				'role' => 'test-Developer'
				)
			);

		$obj = $this->objFromFixture('ExtensionData', 'testmodule');
		$extensionId = $obj->ID;
		$ExtensionAuthorController = new ExtensionAuthorController();
		$memberId = $ExtensionAuthorController->storeAuthorsInfo($authorsRawData,$extensionId);
		$member = Member::get()->byID($memberId['0']);

		$this->assertEquals($member->Email , 'testuser@test.com');
		$this->assertEquals($member->FirstName , 'TestUser');
		$this->assertEquals($member->HomePage , 'www.test.com');
		$this->assertEquals($member->Role , 'test-Developer');
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