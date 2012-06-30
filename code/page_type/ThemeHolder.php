<?php
class ThemeHolder extends ExtensionCRUD {

}

/**
 * Controller for the Theme Search page.
 *
 * @package extensionmanager
 */
class ThemeHolder_Controller extends ExtensionCRUD_Controller {
	
	/**
	 * Setting up the form.
	 *
	 * @return Form .
	 */
	function ThemeUrlForm() {
		return $this->UrlForm() ;
	}
}			