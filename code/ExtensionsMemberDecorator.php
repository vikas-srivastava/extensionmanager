<?php
/**
 * For creating has_many relationship with Member class
 * 
 *
 * @package extensionmanager
 */
class ExtensionsMemberDecorator extends DataExtension {
	
	static $has_many = array(
        'Extensions' => 'ExtensionData',
    );
}