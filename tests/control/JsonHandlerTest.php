<?php
/**
 * Test for JsonHandler class functions
 *
 * @package extensionmanager
 */

class MockVcsRepository {
	function getDriver() {
		return new MockDriver();
	}
}

class MockDriver {
	function getComposerInformation($rootIdentifier) {
		return "fake JSON array with deliberate errors in it";
	}
	function getRootIdentifier() {
	}
}


class JsonHandlerTest extends SapphireTest {

	/*
	 * Check if cloneJson function returns Error Messages if user 
	 * trying to submit wrong Urls
	 *
	 */
	/*public function testClonejson() {

		$this->json = new JsonHandler();

		$this->submittedURLs = array(
			'ValidRepoHaveComposerJsonUrl' => 'https://github.com/vikas-srivastava/demo_module_repo.git',
			'ValidRepoButNoComposerJsonUrl' => 'https://github.com/vikas-srivastava/NoComposer.git',
			'InvalidRepoUrl' => 'http://www.google.com',
			'InvalidUrlHaveComposerJson' => 'http://www.openbees.org',
			);

		$this->assertArrayHasKey('ErrorMsg', $this->json->cloneJson($this->submittedURLs['InvalidRepoUrl']));
		$this->assertArrayHasKey('ErrorMsg', $this->json->cloneJson($this->submittedURLs['ValidRepoButNoComposerJsonUrl']));
		$this->assertArrayHasKey('ErrorMsg', $this->json->cloneJson($this->submittedURLs['InvalidUrlHaveComposerJson']));
		$this->assertArrayHasKey('AllRelease', $this->json->cloneJson($this->submittedURLs['ValidRepoHaveComposerJsonUrl']));
		$this->assertArrayHasKey('LatestRelease', $this->json->cloneJson($this->submittedURLs['ValidRepoHaveComposerJsonUrl']));		
	}*/



    /**
     * @expectedException InvalidArgumentException
     * see: http://www.phpunit.de/manual/3.2/en/writing-tests-for-phpunit.html#writing-tests-for-phpunit.exceptions.examples.ExceptionTest.php
     */
    function testJsonHandler() {
    	$jsonHandler = new JsonHandler('https://github.com/vikas-srivastava/demo_module_repo.git');
    	$jsonHandler->repo = new MockVCSRepository();
    	$jsonHandler->cloneJson();
    }
}
