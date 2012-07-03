<?php
/**
 * Model for the Theme Search page.
 *
 * @package extensionmanager
 */
class ThemeHolder extends ExtensionHolder {
}

/**
 * Controller for the Theme Search page.
 *
 * @package extensionmanager
 */
class ThemeHolder_Controller extends ExtensionHolder_Controller {
	
	/**
	 * Setting up the form.
	 *
	 * @return Form .
	 */
	function ThemeUrlForm() {
		return $this->UrlForm() ;
	}
}			