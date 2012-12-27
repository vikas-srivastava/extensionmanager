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
	public static function save_snapshot($thumbnailUrl, $extensionName) {

		$folderToSave = 'assets/Uploads/Snapshots/';

		$folderObject = Folder::get()->filter("Filename" , $folderToSave)->first();

		if(!$folderObject) {
			$folderObject = Folder::find_or_make('Uploads/Snapshots/');
			$folderObject->write();
		}

		$fileExtension = preg_replace('/^.*\.([^.]+)$/D', '$1', $thumbnailUrl);

		$thumbnailBaseName = str_replace('/', '-', $extensionName);

		$thumbnailName = $thumbnailBaseName.'-thumbnail.'.$fileExtension;

		$ch = curl_init();
		$timeout = 30;
		curl_setopt($ch,CURLOPT_URL,$thumbnailUrl);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		$response = curl_getinfo($ch);
		curl_close($ch);

		if($response['http_code'] == '404') {
			throw new InvalidArgumentException(
				"Image not found on given Url Please check 'Snapshot' field in composer.json file");
		}

		$imageContent = $data;

		if($folderObject ) {
			$thumbnailFile = fopen(BASE_PATH.DIRECTORY_SEPARATOR.$folderToSave.$thumbnailName, 'w');
			fwrite($thumbnailFile, $imageContent);
			fclose($thumbnailFile);
		} else {
			throw new InvalidArgumentException("Could not create $folderToSave , Please create it mannually ");
		}

		if($thumbnailObject = Image::get()->filter("Name" , $thumbnailName)->first()) {
			return $thumbnailObject->ID ;
		} else {
			$thumbnailObject = new Image();
			$thumbnailObject->ParentID = $folderObject->ID;
			$thumbnailObject->Name = $thumbnailName;
			$thumbnailObject->OwnerID = (Member::currentUser() ? Member::currentUser()->ID : 0);
			$thumbnailObject->write();
			return $thumbnailObject->ID ;
		}
	}
}