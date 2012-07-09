<?php
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
    );

    static $has_one = array(
	'ExtensionData' => 'ExtensionData',
	);

    static $summary_fields = array(
    'ID',
    'ExtensionDataID',
    'PrettyVersion',
    );
}