<?php
/**
 * Acts as base class for stroing and handling 
 * Extensions(Module/Widget/Theme) Versions data.
 *
 * @package extensionmanager
 */
class ExtensionVersion extends DataObject {

	static $db = array(	
       'SourceType' => 'Varchar(300)',
       'SourceUrl' => 'Varchar(300)',
       'SourceReference' => 'Varchar(300)',
       'DistType' => 'Varchar(300)',
       'DistUrl' => 'Varchar(300)',
       'DistReference' => 'Varchar(300)',
       'DistSha1Checksum' => 'Varchar(300)',
       'Version' => 'Varchar(300)',
       'PrettyVersion' => 'Varchar(300)',
       'ReleaseDate' =>  'SS_Datetime',
       );

	static $has_one = array(
       'ExtensionData' => 'ExtensionData',
       );

	static $summary_fields = array(
       'ID',
       'ExtensionDataID',
       'PrettyVersion',
       );

	/**
	 * Get each version belongs to Extension
	 * Url ID
	 *
	 * @param int $extensionId
	 * @return dataobjectset
	 */
	public static function getExtensionVersion($extensionId) {
		return ExtensionVersion::get()->filter(array('ExtensionDataID' => $extensionId));
	}

	/**
	 * Get each version belongs to Extension
	 * Url ID
	 *
	 * @param int $extensionId
	 * @return dataobject
	 */
	public static function getLatestVersionDistUrl($extensionId) {
		return ExtensionVersion::get()->filter(array('ExtensionDataID' => $extensionId))->exclude('Version', '9999999-dev')->sort('Version','DESC')->First();
	}
}