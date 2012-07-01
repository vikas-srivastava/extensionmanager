<?php
class ThemeHolder extends Page {

}

/**
 * Controller for the Theme Search page.
 *
 * @package extensionmanager
 */
class ThemeHolder_Controller extends Page_Controller {
	
	/**
	 * Setting up the form.
	 *
	 * @return Form .
	 */
	function ThemeUrlForm() {
		return $this->UrlForm() ;
	}
}			