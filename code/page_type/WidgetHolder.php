<?php
class WidgetHolder extends ExtensionHolder {

}

/**
 * Controller for the module holder page.
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