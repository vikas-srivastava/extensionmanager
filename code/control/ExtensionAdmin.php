<?php
/**
 * Model Admin for controlling ExtensionData class in CMS.
 *
 * @package extensionmanager
 */
class ExtensionAdmin extends ModelAdmin {

	static $menu_title = "Extensions";
	static $url_segment = "extensions";

	static $managed_models = array(
		"ExtensionData",
		"ExtensionVersion",
		"ExtensionCategory",
		"ExtensionKeywords",
		"Member",
	);
}