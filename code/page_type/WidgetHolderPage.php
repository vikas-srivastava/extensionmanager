<?php
/**
 * Model for the widget search page.
 *
 * @package extensionmanager
 */
class WidgetHolderPage extends ExtensionHolderPage
{
    public static $db = array(
        'AddContent' => 'HTMLText',
        );

    public static $default_records = array(
        array('Title' => "Widgets")
        );

    //copied from addons module
    public static $defaults = array(
        'AddContent' => "
		<h3>How do I submit a Widget to the SilverStripe directory?</h3>

		<p>Complete and submit the form below. </p>

		<h3>What happens after I submit my Widget?</h3>

		<p>Our Widget reviewers at SilverStripe are notified, and they will review your submission and contact you if they have questions. Please note that we are verifying that your Widget will install, but we won't do a full code review.</p>
		<p>You'll be notified when your Widget has been listed on the site. We try and approve new submissions quickly but please know that it typically takes at least 4 weeks for your Widget to appear on the SilverStripe website. If you have questions, please contact <a href=\"mailto:Widgets@silverstripe.org\">Widgets@silverstripe.org</a>.</p>

		<h3>What if I need to make changes to my Widget?</h3>

		<p>Once your Widget is listed on the SilverStripe website, you can edit it via the same submission form </p>",

        );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab("Root.Main", new HTMLEditorField("AddContent", "Content for 'add' page"));
        return $fields;
    }
}

/**
 * Controller for the widget search page.
 *
 * @package extensionmanager
 */
class WidgetHolderPage_Controller extends ExtensionHolderPage_Controller
{

    public static $urlhandlers = array(
        'addnew' => 'addnew',
        );

    public function init()
    {
        parent::init();
        $this->extensionType = 'Widget';
    }

    /**
     * Setting up the form for widget submission.
     *
     * @return Array .
     */
    public function WidgetSubmissionForm()
    {
        $formSectionData = new DataObject();
        $formSectionData->Form = $this->AddForm($this->extensionType);
        $formSectionData->Content = $this->dataRecord->AddContent;
        return $formSectionData;
    }

    /**
     * Show widget list on page
     *
     * @return Array .
     */
    public function WidgetList()
    {
        $widgets = ExtensionData::get()->filter(array('Type' => 'Widget', 'Accepted' => '1'))->sort('Name');
        $paginatedList = new PaginatedList($widgets, $this->request);
        $paginatedList->setPageLength(4);
        return $paginatedList;
    }

    /**
     * Show widget Search form.
     *
     * @return Array .
     */
    public function WidgetSearch()
    {
        return $this->extensionSearch();
    }

    /**
     * Show Widget data.
     *
     * @return array
     */
    public function show()
    {
        $selectedWidget = $this->SelectedWidget();
        if ($selectedWidget) {
            return array(
                "Title" => $selectedWidget->Name,
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
    public function SelectedWidget()
    {
        $widget = null;
        $param = $this->getRequest()->param("ID");
        if ($param) {
            $widget =  ExtensionData::get()->where("(ID = '$param' OR URLSegment = '$param') AND (Type = 'Widget') AND (Accepted = '1')")->first();
        }
        return $widget;
    }
}
