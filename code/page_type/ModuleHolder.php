<?php
class ModuleHolder extends ExtensionHolder {

}

/**
 * Controller for the module holder page.
 *
 * @package extensionmanager
 */
class ModuleHolder_Controller extends ExtensionHolder_Controller {

	/**
	 * Setting up the form.
	 *
	 * @return Form .
	 */
	function ModuleUrlForm() {
		return $this->UrlForm() ;
	}
}			