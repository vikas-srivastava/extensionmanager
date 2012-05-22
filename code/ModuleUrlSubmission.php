<?php
class ModuleUrlSubmission extends DataObject {
	static $db = array(
		'Url' => 'Varchar(100)',
		'MemberID' => 'Int(11)',
	);
	/*static $belongs_many_many = array(
		'Members' => 'Member'
	);*/
}

class ModuleUrlSubmission_Controller    
