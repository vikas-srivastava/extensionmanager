<?php
/**
 * Test for JsonHandler class functions
 *
 * @package extensionmanager
 */


class JsonHandlerTest extends SapphireTest {

	static $fixture_file = '../ExtensionManagerTest.yml';

	/*
	 * Check if cloneJson function returns Error Messages if user 
	 * trying to submit wrong Urls
	 *
	 */
	public function testClonejson() {

		$this->json = new JsonHandler();

		$submittedURLs = array(
			'ValidRepoHaveComposerJsonUrl' => 'https://github.com/vikas-srivastava/demo_module_repo.git',
			'ValidRepoButNoComposerJsonUrl' => 'https://github.com/vikas-srivastava/NoComposer.git',
			'InvalidRepoUrl' => 'http://www.google.com',
			'InvalidUrlHaveComposerJson' => 'http://www.openbees.org',
			);

		$this->assertArrayHasKey('ErrorMsg', $this->json->cloneJson($submittedURLs['InvalidRepoUrl']));
		$this->assertArrayHasKey('ErrorMsg', $this->json->cloneJson($submittedURLs['ValidRepoButNoComposerJsonUrl']));
		$this->assertArrayHasKey('ErrorMsg', $this->json->cloneJson($submittedURLs['InvalidUrlHaveComposerJson']));
		$this->assertArrayHasKey('AllRelease', $this->json->cloneJson($submittedURLs['ValidRepoHaveComposerJsonUrl']));		
	}
}