<?php
/**
 * Test for JsonHandler class functions
 *
 * @package extensionmanager
 */

class MockVcsRepository {
	
	function getPackages() {
		$packages = new MockMemoryPackage();
		return array(
			'0' => $packages
			);
	}

	function findPackage() {	
	}
}

class MockMemoryPackage {
	
	function getPrettyName() {
	}

	function getPrettyVersion() {
	}
}

class JsonHandlerTest extends SapphireTest {

	function testCloneJsonFunction() {
		$jsonHandler = new JsonHandler('https://github.com/vikas-srivastava/demo_module_repo.git');
		$jsonHandler->repo = new MockVCSRepository();
		$result = $jsonHandler->cloneJson();
		$this->assertArrayHasKey('ErrorMsg', $result);
	}
}