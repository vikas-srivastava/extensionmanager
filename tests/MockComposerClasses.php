<?php
/**
 * Provide mock classes and function of composer
 *
 * @package extensionmanager
 * @subpackage tests
 */

class MockVcsRepositoryWithNameAbsent {
	
	function getPackages() {
		$packages = new MockMemoryPackageWithNameAbsent();
		return array($packages);
	}

	function findPackage() {	
	}
}

class MockMemoryPackageWithNameAbsent {
	
	function getPrettyName() {
	}

	function getPrettyVersion() {
	}
}

class MockVcsRepositoryWithWrongNameFormat {
	
	function getPackages() {
		$packages = new MockMemoryPackageWithWrongNameFormat();
		return array($packages);
	}

	function findPackage() {	
	}
}

class MockMemoryPackageWithWrongNameFormat {
	
	function getPrettyName() {
		return 'silverstripe\@#cms';
	}

	function getPrettyVersion() {
	}
}

class MockVcsRepositoryWithCapitalLattersInName {
	
	function getPackages() {
		$packages = new MockMemoryPackageWithCapitalLattersInName();
		return array($packages);
	}

	function findPackage() {	
	}
}

class MockMemoryPackageWithCapitalLattersInName {
	
	function getPrettyName() {
		return 'SilverStripe/Cms';
	}

	function getPrettyVersion() {
	}
}

class MockVCSRepositoryWithRealValues {
	
	function getPackages() {
		$package0 = new MockMemoryPackageTagVersion();
		$package1 = new MockMemoryPackageMasterBranch();
		return array($package0,$package1);
	}

	function findPackage($name, $version) {
		foreach ($this->getPackages() as $package) {
			if ($name === $package->getName() && $version === $package->getVersion()) {
				return $package;
			}	
		}
	}
}

class MockMemoryPackageTagVersion {
	
	function getPrettyName() {
		return 'silverstripe/cms';
	}

	function getName() {
		return 'silverstripe/cms';
	}

	function getVersion() {
		return 'v0.1';
	}
}

class MockMemoryPackageMasterBranch {
	
	function getPrettyName() {
		return 'silverstripe/cms';
	}

	function getName() {
		return 'silverstripe/cms';
	}

	function getVersion() {
		return '9999999-dev';
	}

	function getDescription() {
		return 'Just Fake Module For Testing';
	}

	function getType() {
		return 'silverstripe/module';
	}

	function getPrettyVersion() {
	}

	function getHomepage() {
	}

	function getLicense() {
	}

	function getSupport() {
	}

	function getTargetDir() {
	}

	function getRequires() {
		$requirePackage = new MockLink();
		return array($requirePackage);
	}

	function getDevRequires() {
	}

	function getConflicts() {
	}

	function getReplaces() {
	}

	function getProvides() {
	}

	function getSuggests() {
	}

	function getRepositories() {
	}

	function getIncludePaths() {
	}

	function getMinimumStability() {
	}

	function getReleaseDate() {
	}

	function getExtra() {
		return array(
			'snapshot' => 'http://openbees.org/images/Demo.jpg'
			);
	}

	function getAuthors() {
		return array(array(
			'name' => 'TestUser',
			'email' => 'testuser@test.com',
			'homepage' => 'www.test.com',
			'role' => 'test-Developer'
			)
		);
	}

	function getKeywords() {
		return array('silverstripe','cms','module');
	}
}

class MockLink {
	function getTarget(){
		return 'silverstripe/framework';
	}

	function getPrettyConstraint() {
		return '3.0.1';
	}
}