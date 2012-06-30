<?php
class WidgetHolder extends ExtensionCRUD {

}

/**
 * Controller for the widget search page.
 *
 * @package extensionmanager
 */
class WidgetHolder_Controller extends ExtensionCRUD_Controller {

	/**
	 * Setting up the form.
	 *
	 * @return Form .
	 */
	function WidgetUrlForm() {
		return $this->UrlForm() ;
	}
}			