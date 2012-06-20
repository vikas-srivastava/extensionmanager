<?php

class ExtensionData extends DataObject {

	static $db = array(	
		//'MemberID' => 'Int',
		'Url' => 'Varchar(100)',
		'Name' => 'VarChar(50)',
		'Description' => 'VarChar(50)',
		'Version' => 'VarChar(500)',
		"Type" => "Enum('Module, Theme, Widget', 'Module')",
		'Keywords' => 'VarChar(500)',
		'Homepage' => 'VarChar(500)',
		'ReleaseTime' => 'SS_Datetime',
		'Licence' => 'VarChar(500)',
		'AuthorsName' => 'VarChar(500)',
		'AuthorsEmail' => 'VarChar(500)',
		'AuthorsHomepage' => 'VarChar(500)',
		'AuthorsRole' => 'VarChar(500)',
		'SupportEmail' => 'VarChar(100)',
		'SupportIssues' => 'VarChar(100)',
		'SupportForum' => 'VarChar(100)',
		'SupportWiki' => 'VarChar(100)',
		'SupportIrc' => 'VarChar(50)',
		'SupportSource' => 'VarChar(100)',
		'TargetDir' => 'VarChar(100)',
		'Require' => 'VarChar(500)',
		'RequireDev' => 'VarChar(500)',
		'Conflict' => 'VarChar(500)',
		'Replace' => 'VarChar(500)',
		'Provide' => 'VarChar(500)',
		'Suggest' => 'VarChar(500)',
		'ConfigVendorDir' => 'VarChar(500)',
		'ConfigBinDir' => 'VarChar(500)',
		'Extra' => 'VarChar(500)',
		'Repositories' => 'VarChar(500)',
		'IncludePath' => 'VarChar(500)',
		'Bin' => 'VarChar(500)',
		'MinimumStability' => 'VarChar(500)',
	);	

	static $searchable_fields = array(
      'Name',
      'Type',
      'Keywords', 
   	);

	static $summary_fields = array(
		'Name',
		'Type',
		'Description',
	);

	static $has_one = array(
        'SubmittedBy' => 'Member'
    );

    static $has_many = array(
        'ModuleID' => 'ModulePage',
    );
	
} 

class ExtensionData_Controller extends Page_Controller {
	
}