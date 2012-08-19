<?php
/**
 * @package extensionmanager
 * @subpackage tests
 */
class JsonHandlerTest extends SapphireTest {

	protected $latestReleasePackage;

	function testCloneJsonFunctionWithNameAbsent() {

		$jsonHandler = new JsonHandler('https://github.com/vikas-srivastava/demo_module_repo.git');
		$jsonHandler->repo = new MockVCSRepositoryWithNameAbsent();
		$result = $jsonHandler->cloneJson();
		$this->assertArrayHasKey('ErrorMsg', $result);
	}

	function testCloneJsonFunctionWithWrongNameFormat() {

		$jsonHandler = new JsonHandler('https://github.com/vikas-srivastava/demo_module_repo.git');
		$jsonHandler->repo = new MockVCSRepositoryWithWrongNameFormat();
		$result = $jsonHandler->cloneJson();
		$this->assertArrayHasKey('ErrorMsg', $result);
	}

	function testCloneJsonFunctionWithCapitalLattersInName() {

		$jsonHandler = new JsonHandler('https://github.com/vikas-srivastava/demo_module_repo.git');
		$jsonHandler->repo = new MockVCSRepositoryWithCapitalLattersInName();
		$result = $jsonHandler->cloneJson();
		$this->assertArrayHasKey('ErrorMsg', $result);
	}

	function testCloneJsonFunctionReturnLatestPackage() {
		$jsonHandler = new JsonHandler('https://github.com/vikas-srivastava/demo_module_repo.git');
		$jsonHandler->repo = new MockVCSRepositoryWithRealValues();
		$result = $jsonHandler->cloneJson();
		$this->assertArrayHasKey('LatestRelease', $result);
	}

	function testSaveJsonFunction() {
		$repoUrl = 'https://github.com/vikas-srivastava/demo_module_repo.git';
		$jsonHandler = new JsonHandler($repoUrl);
		$jsonHandler->repo = new MockVCSRepositoryWithRealValues();
		$result = $jsonHandler->cloneJson();
		$this->latestReleasePackage = $result['LatestRelease'];
		$result = $jsonHandler->saveJson();

		$this->assertArrayNotHasKey('ErrorMsg', $result);
		$this->assertArrayHasKey('ExtensionID', $result);

		$extensionId = $result['ExtensionID'];
		$extensionData = ExtensionData::get()->byID($extensionId);
		list($vendorName, $extensionName) = explode("/", $this->latestReleasePackage->getPrettyName());

		$this->assertEquals($extensionData->Name, $extensionName);
	}
}