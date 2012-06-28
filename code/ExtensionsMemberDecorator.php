<?php
class ExtensionsMemberDecorator extends DataExtension {
	
	static $has_many = array(
        'Extensions' => 'ExtensionData',
    );
}