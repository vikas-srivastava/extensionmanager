<?php
/**
 * Class containing methods for fetching and storing
 * extension Category information.
 *
 * @package extensionmanager
 */
class ExtensionCategory extends DataObject {

	static $db = array(
		'CategoryName' => 'Varchar(100)',
		);

	static $has_many = array(
		'Extensions' => 'ExtensionData',
		);

	static $searchable_fields = array(
		'CategoryName' => array(
			'title' => 'Category Name',
			'field' => 'TextField',
			'filter' => 'PartialMatchFilter',
			),
		'Extensions.Name' => array(
			'title' => 'Extension Name',
			'field' => 'TextField',
			'filter' => 'PartialMatchFilter',
			)
		);

	static $summary_fields = array(
		'CategoryName' => array(
			'title' => 'Category Name',
			),
		);

	/**
	  * Get Category Name of Extension
	  *
	  *	@param extensionData
	  * @return string
	  */
	public static function getExtensionCategory($categoryID) {
		$category = ExtensionCategory::get()->byID($categoryID);
		if($category) {
			return $category->CategoryName;
		}
	}
}