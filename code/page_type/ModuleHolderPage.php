<?php
/**
 * Model for the module search page.
 *
 * @package extensionmanager
 */

class ModuleHolderPage extends ExtensionHolderPage
{

    public static $db = array(
        'AddContent' => 'HTMLText',
        );

    public static $default_records = array(
        array('Title' => "Modules")
        );

    //copied from addons module
    public static $defaults = array(
        'AddContent' => "
		<p>Our module reviewers at SilverStripe are notified, and they will review your submission and contact you if they have questions. Please note that we are verifying that your module will install, but we won't do a full code review.</p>
		<p>You'll be notified when your module has been listed on the site. We try and approve new submissions quickly but please know that it typically takes at least 4 weeks for your module to appear on the SilverStripe website. If you have questions, please contact <a href=\"mailto:modules@silverstripe.org\">modules@silverstripe.org</a>.</p>",
    );

    public function canCreate($member = null)
    {
        return true;
    }

    public function PageNavClass()
    {
        return "modules";
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab("Root.Main", new HTMLEditorField("AddContent", "Content for 'add' page"));
        return $fields;
    }
}

/**
 * Controller for the module search page.
 *
 * @package extensionmanager
 */
class ModuleHolderPage_Controller extends ExtensionHolderPage_Controller
{

    public function init()
    {
        parent::init();
        $this->extensionType = 'Module';
    }

    /**
     * Setting up the form for module submission.
     *
     * @return Array .
     */
    public function ModuleSubmissionForm()
    {
        $formSectionData = new DataObject();
        $formSectionData->Form = $this->AddForm($this->extensionType);
        $formSectionData->Content = $this->dataRecord->AddContent;
        return $formSectionData;
    }

    /**
     * Show module list on page
     *
     * @return Array .
     */
    public function ModuleList()
    {
        $modules = ExtensionData::get()->filter(array('Type' => 'Module', 'Accepted' => '1'))->sort('Name');
        $paginatedList = new PaginatedList($modules, $this->request);
        $paginatedList->setPageLength(4);
        return $paginatedList;
    }

    /**
     * Show Module Search form.
     *
     * @return Array .
     */
    public function ModuleSearch()
    {
        return $this->extensionSearch();
    }

    /**
     * Show module data.
     *
     * @return array
     */
    public function show()
    {
        $selectedModule = $this->SelectedModule();
        if ($selectedModule) {
            return array(
                "Title" => $selectedModule->Name,
                );
        } else {
            return $this->httpError("404");
        }
    }

    /**
     * Get Selected Module.
     *
     * @return Array .
     */
    public function SelectedModule()
    {
        $module = null;
        $param = $this->getRequest()->param("ID");
        if ($param) {
            $module =  ExtensionData::get()->where("(ID = '$param' OR URLSegment = '$param') AND (Type = 'Module') AND (Accepted = '1')")->first();
        }
        return $module;
    }
}
