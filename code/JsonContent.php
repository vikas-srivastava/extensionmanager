<?php 
class JsonContent extends DataObject {
	static $db = array(
		
		'Url' => 'Varchar(100)',
		'ModuleName'=>'Varchar(40)',
		'Description'=> 'Varchar(100)',
		'Keywords'=> 'Varchar(100)',
		'MemberID' => 'Int(11)',
		'Version'=> 'Varchar(40)',
		'Homepage'=> 'Varchar(100)',
		'Author'=> 'Varchar(100)',
		'RepositoryType'=> 'Varchar(20)',
		'RepositoryUrl'=>'Varchar(100)',
		'BugsEmail'=> 'Varchar(50)',
		'BugsUrl'=> 'Varchar(50)',
		'LicensesType'=> 'Varchar(50)',
		'LicenseUrl' => 'Varchar(100)',
		'Dependencies' => 'Varchar(400)',
	);

	static $searchable_fields = array(
		"ModuleName",
		"Author",
		"Keywords",
	);

	static $summary_fields = array(
		"ModuleName",
		"Description",
	);
}
