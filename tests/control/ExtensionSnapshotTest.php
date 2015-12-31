<?php
/**
* @package extensionmanager
* @subpackage tests
*/
class ExtensionSnapshotTest extends SapphireTest
{

    public static $fixture_file = 'extensionmanager/tests/ExtensionManagerTest.yml';

    public function testSaveSnapshot()
    {
        $obj = $this->objFromFixture('ExtensionData', 'testmodule');
        $realUrl = 'http://openbees.org/images/Demo.jpg';

        $imageId = ExtensionSnapshot::save_snapshot($realUrl, $obj->Name);
        $image = Image::get()->byID($imageId);

        $this->assertFileExists(BASE_PATH.DIRECTORY_SEPARATOR.$image->Filename);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSaveSnapshotException()
    {
        $obj = $this->objFromFixture('ExtensionData', 'testmodule');
        $fakeUrl = 'http://openbees.org/images/FakeImage.jpg';

        ExtensionSnapshot::save_snapshot($fakeUrl, $obj->Name);
    }
}
