<?php
class ExtensionCategory extends DataObject {

	static $db = array(	
		'CategoryName' => 'Varchar(100)',
		);

	static $has_many = array(
		'Extensions' => 'ExtensionData',
		);	

	static $summary_fields = array(
		'ID',
		'CategoryName',
		);
}