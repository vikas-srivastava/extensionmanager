<?php
/**
 * Class containing Factory methods for handling
 * extension authors information.
 *
 * @package extensionmanager
 */
class ExtensionAuthor extends DataObject {
	static $db = array (
		'Email' => 'varchar(300)',
		'FirstName' => 'Varchar(100)',
		'LastName' => 'Varchar(100)',
		'HomePage' => 'Varchar(300)',
		'Role' => 'Varchar(300)',
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
class ExtensionAuthorController extends Controller {

	/**
	  * Store Multiple Author Info in Member class
	  * Url ID
	  *
	  * @param array $authorsRawData, int $extensionId
	  */
	public static function storeAuthorsInfo($authorsRawData,$extensionId) {

		$totalAuthors = count($authorsRawData);
		$extensionAuthorsId = array();
		
		foreach($authorsRawData as $author) {
			if(!((array_key_exists('name', $author)))) {
				throw new InvalidArgumentException('Make sure Name field exists in author info');
			}

			if(!((array_key_exists('email', $author)))) {
				throw new InvalidArgumentException('make sure Email field exists in author info');
			}

			$name = preg_split('/ (?!.* )/',$author['name']);
			$firstName = $name[0];
			$lastName = $name[1];

			if(ExtensionAuthor::get()->filter("Email" , $author['email'])->first()) {
				$extensionAuthor = ExtensionAuthor::get()->filter("Email" , $author['email'])->first();
			} else {
				$extensionAuthor = new ExtensionAuthor;
			}

			$extensionAuthor->Email = $author['email'];
			$extensionAuthor->FirstName = $firstName;
			$extensionAuthor->LastName = $lastName;

			if(array_key_exists('homepage', $author)) {
				$extensionAuthor->HomePage = $author['homepage'];
			}

			if(array_key_exists('role', $author)) {
				$extensionAuthor->Role = $author['role'];
			}

			$extensionAuthor->write();
			$extensionAuthor->AuthorOf()->add($extensionId);
			array_push($extensionAuthorsId ,$extensionAuthor->ID);
		}

		if(count($extensionAuthorsId) == $totalAuthors) {
			return $extensionAuthorsId;
		} else {
			throw new InvalidArgumentException('Unable to store some authors Info');
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