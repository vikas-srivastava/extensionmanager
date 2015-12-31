<?php
/**
 * Model Admin for controlling ExtensionData class in CMS.
 *
 * @package extensionmanager
 */
class ExtensionAdmin extends ModelAdmin
{

    public static $menu_title = "Extensions";
    public static $url_segment = "extensions";

    public static $managed_models = array(
        "ExtensionData",
        "ExtensionVersion",
        "ExtensionCategory",
        "ExtensionKeywords",
        "Member",
    );
}
