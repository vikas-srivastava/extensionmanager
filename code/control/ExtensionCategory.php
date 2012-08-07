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

	static $summary_fields = array(
		'ID',
		'CategoryName',
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