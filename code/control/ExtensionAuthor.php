<?php
/**
 * Class containing Factory methods for handling 
 * extension authors information.
 *
 * @package extensionmanager
 */
class ExtensionAuthorController extends Controller {
	
	/**
	  * Store Multiple Author Info in Member class
	  * Url ID
	  *
	  * @param array $authorsRawData, int $extensionId 
	  */
	public static function storeAuthorsInfo($authorsRawData,$extensionId) {	
		
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
				$member->AuthorOf()->add($extensionId);				
			} else {
				$member = new Member();
		        $member->Email = $authorsEmail[$i];
		        $member->FirstName = $authorsName[$i];
		        $member->HomePage = $authorsHomepage[$i];
				$member->Role = $authorsRole[$i];
		        $member->write();
		        $member->AuthorOf()->add($extensionId);
			}
		}
	}

	/**
	  * Get Author Info of Extension
	  *
	  * @param  int $extensionId 
	  * @return array
	  */
	public static function getAuthorsInformation($extensionId) {
		$extensionId = ExtensionData::get()->byID($extensionId);
		return $extensionId->ExtensionAuthors();
	}

	/**
	 * Get comma seprated list of authors email
	 *
	 * @param  int $extensionId
	 * @return string 
	 */
	public static function getAuthorsEmail($extensionId) {
		$authors = ExtensionData::get()->byID($extensionId)->ExtensionAuthors();
		$emails =  array();
		
		foreach ($authors as $author) {
			array_push($emails, $author->Email);
		}

		$commaSeparatedEmail = implode(",", $emails);
		return $commaSeparatedEmail;
	}
}