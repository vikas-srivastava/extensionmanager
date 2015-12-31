<?php
/**
 * Provide mock classes and function of composer
 *
 * @package extensionmanager
 * @subpackage tests
 */

class MockVcsRepositoryWithNameAbsent
{

    public function getPackages()
    {
        $packages = new MockMemoryPackageWithNameAbsent();
        return array($packages);
    }

    public function findPackage()
    {
    }
}

class MockMemoryPackageWithNameAbsent
{

    public function getPrettyName()
    {
    }

    public function getPrettyVersion()
    {
    }
}

class MockVcsRepositoryWithWrongNameFormat
{

    public function getPackages()
    {
        $packages = new MockMemoryPackageWithWrongNameFormat();
        return array($packages);
    }

    public function findPackage()
    {
    }
}

class MockMemoryPackageWithWrongNameFormat
{

    public function getPrettyName()
    {
        return 'silverstripe\@#cms';
    }

    public function getPrettyVersion()
    {
    }
}

class MockVcsRepositoryWithCapitalLattersInName
{

    public function getPackages()
    {
        $packages = new MockMemoryPackageWithCapitalLattersInName();
        return array($packages);
    }

    public function findPackage()
    {
    }
}

class MockMemoryPackageWithCapitalLattersInName
{

    public function getPrettyName()
    {
        return 'SilverStripe/Cms';
    }

    public function getPrettyVersion()
    {
    }
}

class MockVCSRepositoryWithRealValues
{

    public function getPackages()
    {
        $package0 = new MockMemoryPackageTagVersion();
        $package1 = new MockMemoryPackageMasterBranch();
        return array($package0,$package1);
    }

    public function findPackage($name, $version)
    {
        foreach ($this->getPackages() as $package) {
            if ($name === $package->getName() && $version === $package->getVersion()) {
                return $package;
            }
        }
    }
}

class MockMemoryPackageTagVersion
{

    public function getPrettyName()
    {
        return 'silverstripe/cms';
    }

    public function getName()
    {
        return 'silverstripe/cms';
    }

    public function getVersion()
    {
        return 'v0.1';
    }
}

class MockMemoryPackageMasterBranch
{

    public function getPrettyName()
    {
        return 'silverstripe/cms';
    }

    public function getName()
    {
        return 'silverstripe/cms';
    }

    public function getVersion()
    {
        return '9999999-dev';
    }

    public function getDescription()
    {
        return 'Just Fake Module For Testing';
    }

    public function getType()
    {
        return 'silverstripe-module';
    }

    public function getPrettyVersion()
    {
    }

    public function getHomepage()
    {
    }

    public function getLicense()
    {
    }

    public function getSupport()
    {
    }

    public function getTargetDir()
    {
    }

    public function getRequires()
    {
        $requirePackage = new MockLink();
        return $requirePackage;
    }

    public function getDevRequires()
    {
    }

    public function getConflicts()
    {
    }

    public function getReplaces()
    {
    }

    public function getProvides()
    {
    }

    public function getSuggests()
    {
    }

    public function getRepositories()
    {
    }

    public function getIncludePaths()
    {
    }

    public function getReleaseDate()
    {
    }

    public function getExtra()
    {
        return array(
            'snapshot' => 'http://openbees.org/images/Demo.jpg'
            );
    }

    public function getAuthors()
    {
        return array(array(
            'name' => 'Test User',
            'email' => 'testuser@test.com',
            'homepage' => 'www.test.com',
            'role' => 'test-Developer'
            )
        );
    }

    public function getKeywords()
    {
        return array('silverstripe','cms','module');
    }
}

class MockLink
{
    public function getTarget()
    {
        return 'silverstripe/framework';
    }

    public function getPrettyConstraint()
    {
        return '3.0.1';
    }
}
