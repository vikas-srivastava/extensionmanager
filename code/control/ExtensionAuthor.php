<?php
/**
 * Class containing Factory methods for handling 
 * extension authors information.
 *
 * @package extensionmanager
 */
class ExtensionAuthor extends Controller {
	
	/**
	  * Store Multiple Author Info in Member class
	  * Url ID
	  *
	  * @param array $authorsRawData, int $extensionDataId 
	  */
	public static function storeAuthorsInfo($authorsRawData,$extensionDataId) {	
		
		$totalAuthors = count($authorsRawData);
		$authorsEmail = array();
		$authorsName = array();
		$authorsHomepage = array();
		$authorsRole = array();

		for ($i = 0; $i < $totalAuthors ; $i++ ) { 
			try {
				if(array_key_exists('email',$authorsRawData[$i])) {
					array_push($authorsEmail, $authorsRawData[$i]['email']);
				} else {
					throw new Exception('Email field not exist in author info');
				}

				if(array_key_exists('name',$authorsRawData[$i])) {
					array_push($authorsName ,$authorsRawData[$i]['name']);
				} else {
					throw new Exception('Name field not exist in author info');
				}

			} catch(Exception $e) {
					echo $e->getMessage();
			}

 			if(array_key_exists('homepage',$authorsRawData[$i])) {
 				array_push($authorsHomepage ,$authorsRawData[$i]['homepage']);
 			} 

 			if(array_key_exists('email',$authorsRawData[$i])) {
 				array_push($authorsRole ,$authorsRawData[$i]['role']);
 			} 			
 		}

		for ($i = 0; $i < $totalAuthors; $i++) { 
			
			if($member = Member::get()->filter("Email" , $authorsEmail[$i])->first()) {
				$member->HomePage = $authorsHomepage[$i];
				$member->Role = $authorsRole[$i];
				$member->write();
				$member->AuthorOf()->add($extensionDataId);				
			} else {
				$member = new Member();
		        $member->Email = $authorsEmail[$i];
		        $member->FirstName = $authorsName[$i];
		        $member->HomePage = $authorsHomepage[$i];
				$member->Role = $authorsRole[$i];
		        $member->write();
		        $member->AuthorOf()->add($extensionDataId);
			}
		}
	}

	/**
	  * Gey Author Info of Extension
	  *
	  * @param  int $extensionDataId 
	  * @return array
	  */
	public static function getAuthorsInformation($extensionDataId) {
		$extensionId = ExtensionData::get()->byID($extensionDataId);
		return $extensionId->ExtensionAuthors();
	}
}