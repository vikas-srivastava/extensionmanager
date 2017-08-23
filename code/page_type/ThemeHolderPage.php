<?php
/**
 * Model for the Theme Search page.
 *
 * @package extensionmanager
 */
class ThemeHolderPage extends ExtensionHolderPage
{
    public static $db = array(
        'AddContent' => 'HTMLText',
        );

    public static $default_records = array(
        array('Title' => "Themes")
        );

    //copied from addons module
    public static $defaults = array(
        'AddContent' => "
		<h3>How do I submit a Theme to the SilverStripe directory?</h3>

		<p>Complete and submit the form below. </p>

		<h3>What happens after I submit my Theme?</h3>

		<p>Our Theme reviewers at SilverStripe are notified, and they will review your submission and contact you if they have questions. Please note that we are verifying that your Theme will install, but we won't do a full code review.</p>
		<p>You'll be notified when your Theme has been listed on the site. We try and approve new submissions quickly but please know that it typically takes at least 4 weeks for your Theme to appear on the SilverStripe website. If you have questions, please contact <a href=\"mailto:Themes@silverstripe.org\">Themes@silverstripe.org</a>.</p>

		<h3>What if I need to make changes to my Theme?</h3>

		<p>Once your Theme is listed on the SilverStripe website, you can edit it via the same submission form </p>",

        );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab("Root.Main", new HTMLEditorField("AddContent", "Content for 'add' page"));
        return $fields;
    }
}

/**
 * Controller for the Theme Search page.
 *
 * @package extensionmanager
 */
class ThemeHolderPage_Controller extends ExtensionHolderPage_Controller
{

    public static $urlhandlers = array(
        'addnew' => 'addnew',
        );

    public function init()
    {
        parent::init();
        $this->extensionType = 'Theme';
    }

    /**
     * Setting up the form for module submission.
     *
     * @return Array .
     */
    public function ThemeSubmissionForm()
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
    public function ThemeList()
    {
        $themes = ExtensionData::get()->filter(array('Type' => 'Theme', 'Accepted' => '1'))->sort('Name');
        $paginatedList = new PaginatedList($themes, $this->request);
        $paginatedList->setPageLength(4);
        return $paginatedList;
    }

    /**
     * Show Theme Search form.
     *
     * @return Array .
     */
    public function ThemeSearch()
    {
        return $this->extensionSearch();
    }

    /**
     * Show Theme data.
     *
     * @return array
     */
    public function show()
    {
        $selectedTheme = $this->SelectedTheme();
        if ($selectedTheme) {
            return array(
                "Title" => $selectedTheme->Name,
                );
        } else {
            return $this->httpError("404");
        }
    }

    /**
     * Get Selected Theme.
     *
     * @return array
     */
    public function SelectedTheme()
    {
        $theme = null;
        $param = $this->getRequest()->param("ID");
        if ($param) {
            $theme =  ExtensionData::get()->where("(ID = '$param' OR URLSegment = '$param') AND (Type = 'Theme') AND (Accepted = '1')")->first();
        }
        return $theme;
    }
}
