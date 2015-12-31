<?php
/**
 * Acts as base class for stroing and handling
 * Extensions(Module/Widget/Theme) Versions data.
 *
 * @package extensionmanager
 */
class ExtensionVersion extends DataObject
{

    public static $db = array(
        'SourceType' => 'Varchar(300)',
        'SourceUrl' => 'Varchar(300)',
        'SourceReference' => 'Varchar(300)',
        'DistType' => 'Varchar(300)',
        'DistUrl' => 'Varchar(300)',
        'DistReference' => 'Varchar(300)',
        'DistSha1Checksum' => 'Varchar(300)',
        'Version' => 'Varchar(300)',
        'PrettyVersion' => 'Varchar(300)',
        'CompatibleSilverStripeVersion' => 'VarChar(20)',
        'ReleaseDate' =>  'SS_Datetime',
        );

    public static $has_one = array(
        'ExtensionData' => 'ExtensionData',
        );

    public static $searchable_fields = array(
        'ExtensionData.Name' => array(
            'title' => 'Extension Name',
            'field' => 'TextField',
            'filter' => 'PartialMatchFilter',
            ),
        'ExtensionData.Type' => array(
            'title' => 'Extension Type',
            ),
        'PrettyVersion' => array(
            'title' => 'Version',
            'field' => 'TextField',
            'filter' => 'PartialMatchFilter',
            ),

        );

    public static $summary_fields = array(
        'ExtensionData.Name' => array(
            'title' => 'Extension Name',
            ),
        'ExtensionData.Type' => array(
            'title' => 'Extension Type',
            ),
        'PrettyVersion' => array(
            'title' => 'Version',
            ),
        'CompatibleSilverStripeVersions' => array(
            'title' => 'Compatible SilverStripe Versions',
            ),
        );

    /**
     * Get each version belongs to Extension
     * Url ID
     *
     * @param int $extensionId
     * @return dataobject
     */
    public static function get_latest_version_dist_url($extensionId)
    {
        return ExtensionVersion::get()->filter(array(
            'ExtensionDataID' => $extensionId,
            'Version' => '9999999-dev'
            ))->First();
    }
}
