<?php
class WidgetHolder extends Page {

}

/**
 * Controller for the widget search page.
 *
 * @package extensionmanager
 */
class WidgetHolder_Controller extends Page_Controller {

	/**
	 * Setting up the form.
	 *
	 * @return Form .
	 */
	function WidgetUrlForm() {
		return $this->UrlForm() ;
	}
}			