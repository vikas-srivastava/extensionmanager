<?php
/**
 * Model for the widget search page.
 * 
 * @package extensionmanager
 */
class WidgetHolder extends ExtensionHolder {

}

/**
 * Controller for the widget search page.
 *
 * @package extensionmanager
 */
class WidgetHolder_Controller extends ExtensionHolder_Controller {

	/**
	 * Setting up the form.
	 *
	 * @return Form .
	 */
	function WidgetUrlForm() {
		return $this->UrlForm() ;
	}
}			