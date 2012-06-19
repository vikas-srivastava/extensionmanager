<?php
class ModulePage extends Page {
	 static $has_one = array(
        'ExtensionData' => 'ExtensionData',
    );
}

class ModulePage_Controller extends Page_Controller {
	
	function __construct() {

	}

	function getName() {
		
	}
}