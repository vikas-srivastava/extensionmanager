<?php
/**
 * Factory class for handling extension snapshot 
 * Related tasks
 * 
 * @package extensionmanager
 */ 

class ExtensionSnapshot extends Controller {

	/**
	  * Save Snapshots of extension in assets folder 
	  *
	  * @param string $thumbnailUrl, $extensionName  
	  * @return int 
	  */
	public static function saveSnapshot($thumbnailUrl, $extensionName) {
		
		$folderToSave = 'assets/Uploads/Snapshots/'; 

		$folderObject = Folder::get()->filter("Filename" , $folderToSave)->first(); 

		$fileExtension = preg_replace('/^.*\.([^.]+)$/D', '$1', $thumbnailUrl);

		$thumbnailBaseName = str_replace('/', '-', $extensionName); 

		$thumbnailName = $thumbnailBaseName.'-thumbnail.'.$fileExtension; 

		$ch = curl_init();
		$timeout = 30;
		curl_setopt($ch,CURLOPT_URL,$thumbnailUrl);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		curl_close($ch);

		$imageContent = $data;

		if($folderObject ) {
			$thumbnailFile = fopen('./../'.$folderToSave.$thumbnailName, 'w');
			fwrite($thumbnailFile, $imageContent); 
			fclose($thumbnailFile); 
		}

		if(!Image::get()->filter("Name" , $thumbnailName)->first()) {
            $thumbnailObject = new Image();
            $thumbnailObject->ParentID = $folderObject->ID; 
            $thumbnailObject->Name = $thumbnailName;
            $thumbnailObject->OwnerID = (Member::currentUser() ? Member::currentUser()->ID : 0);
            $thumbnailObject->write();
            return $thumbnailObject->ID ;
        }
    } 
}