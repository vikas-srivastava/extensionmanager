<?php
/**
 * Class containing methods for fetching and storing
 * extension Category information.
 *
 * @package extensionmanager
 */
class ExtensionCategory extends DataObject
{

    public static $db = array(
        'CategoryName' => 'Varchar(100)',
        );

    public static $has_many = array(
        'Extensions' => 'ExtensionData',
        );

    public static $searchable_fields = array(
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

    public static $summary_fields = array(
        'CategoryName' => array(
            'title' => 'Category Name',
        ),
    );
}
