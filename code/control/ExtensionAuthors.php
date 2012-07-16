<?php 
class ExtensionAuthors extends DataObject {
	
	static $db = array (
		'HomePage' => 'Varchar(300)',
		'Role' => 'Varchar(300)',
		);

	static $has_one = array(
		'Member' => 'Member',
		);

	static $many_many = array(
		'ExtensionData' => 'ExtensionData',
		);
}	

class ExtensionAuthors_Controller extends Controller {

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
			$author = new ExtensionAuthors();
			$member = Member::get()->filter("Email" , $authorsEmail[$i]);
			if($member) {
				$author->MemberId = $member->ID ;
				$author->ExtensionDataID = $extensionDataId;
				$author->HomePage = $authorsHomepage[$i];
				$author->Role = $authorsRole[$i];				
			} else {

				$Member = new Member();
		        $Member->Email = $authorsEmail[$i];
		        $Member->FirstName = $authorsName[$i];
		        $Member->write();

				$author->MemberId = $Member->ID ;
				$author->ExtensionDataID = $extensionDataId;
				$author->HomePage = $authorsHomepage[$i];
				$author->Role = $authorsRole[$i];
			}

			$author->write();
			if (!$author->ID) {
				
				throw new Exception('Author info could not be save');
			}
		}			//$author->ManyMany()->add($record);	
	}
}