<?php

class ModuleTest extends FunctionalTest{
	
	function testIfModulePageExist() {
		static $fixture_file = 'extensionmanager/tests/ExtensionManagerTest.yml';
		
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
