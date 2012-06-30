<?php
class ModuleHolder extends ExtensionCRUD {

}

/**
 * Controller for the module search page.
 *
 * @package extensionmanager
 */
class ModuleHolder_Controller extends ExtensionCRUD_Controller {

	/**
	 * Setting up the form.
	 *
	 * @return Form .
	 */
	function ModuleUrlForm() {
		return $this->UrlForm() ;
	}
}			