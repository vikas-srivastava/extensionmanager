<?php
/**
 * Base class for handling extension tags
 *
 * @package extensionmanager
 */

class ExtensionKeywords extends DataObject
{

    public static $db = array(
        'KeywordName' => 'Varchar(100)',
        );

    public static $many_many = array(
        'Extension' => 'ExtensionData',
        );

    public static $searchable_fields = array(
        'KeywordName' => array(
            'title' => 'Keyword Name',
            'field' => 'TextField',
            'filter' => 'PartialMatchFilter',
            ),
        'Extension.Name' => array(
            'title' => 'Extension Name',
            'field' => 'TextField',
            'filter' => 'PartialMatchFilter',
            )
        );

    public static $summary_fields = array(
        'KeywordName' => array(
            'title' => 'Keyword Name',
            ),
        );

    /**
      * Store Keywords in seprate dataobject
      *
      * @param array $authorsRawData, int $extensionId
      */
    public static function save_keywords($rawKeywordData, $extensionId)
    {
        $totalKeywords = count($rawKeywordData);
        for ($i = 0; $i < $totalKeywords; $i++) {
            if ($keyword = ExtensionKeywords::get()->filter("KeywordName", $rawKeywordData[$i])->first()) {
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
