<?php
class ExtensionAdmin extends ModelAdmin {
	static $menu_title = "Extensions";
	static $url_segment = "extensions";

	static $managed_models = array(
		"JsonContent",
		"Member",
	);
}	