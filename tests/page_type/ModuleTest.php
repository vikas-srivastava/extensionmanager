<?php
/**
 * Test for show() function of Module class
 * 
 * @package extensionmanager
 */
class ModuleTest extends FunctionalTest{
	
	static $fixture_file = 'extensionmanager/tests/ExtensionManagerTest.yml';
	
	function testIfModulePageExist() {
		
		$testModule = $this->objFromFixture(
			'Module',
			'testmodule'
			);
		
		$response = $this->get('module/show/test-url');
		$this->assertContains(
			'Sorry that Module could not be found',
			$response->getBody(),
			'page not found'
			);
	}
}
