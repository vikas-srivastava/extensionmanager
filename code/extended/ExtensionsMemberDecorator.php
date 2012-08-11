<?php
/**
 * For creating relationship between ExtensionData and  Member class
 * 
 *
 * @package extensionmanager
 */
class ExtensionsMemberDecorator extends DataExtension {
	
	static $db = array (
		'HomePage' => 'Varchar(300)',
		'Role' => 'Varchar(300)',
		);

	static $has_many = array(
		'SubmittedExtension' => 'ExtensionData',
		);

	static $many_many = array(
		'AuthorOf' => 'ExtensionData',
		);

	static $searchable_fields = array(
		'AuthorOf.Name' => array(
			'title' => 'Extension Name',
			'field' => 'TextField',
			'filter' => 'PartialMatchFilter',
			)
		);
}