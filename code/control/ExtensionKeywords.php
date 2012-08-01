<?php
/**
 * Base class for handling extension tags 
 * 
 * @package extensionmanager
 */	

class ExtensionKeywords extends DataObject {

	static $db = array(
		'KeywordName' => 'Varchar(100)',
		);

	static $many_many = array(
		'Extension' => 'ExtensionData',
		);

	static $searchable_fields = array(
		'KeywordName',
		);

	static $summary_fields = array(
		'KeywordName',
		);

	/**
	  * Store Keywords in seprate dataobject
	  *
	  * @param array $authorsRawData, int $extensionId 
	  */
	public function saveKeywords($rawKeywordData, $extensionId) {

		$totalKeywords = count($rawKeywordData);
		for ($i = 0; $i < $totalKeywords; $i++) { 	
			
			if($keyword = ExtensionKeywords::get()->filter("KeywordName" , $rawKeywordData[$i])->first()) {
				$keyword->Extension()->add($extensionId);				
			} else {
				$keyword = new ExtensionKeywords();
		        $keyword->KeywordName = $rawKeywordData[$i] ;
		        $keyword->write();
		        $keyword->Extension()->add($extensionId);
			}
		}
	}
}