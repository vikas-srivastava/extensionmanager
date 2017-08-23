<?php
/**
 * This class will serve as base class for
 * all the ExtensionHolderPage classes (module/widget/theme)
 * contains extension submission forms and their handler.
 *
 * @package extensionmanager
 */
class ExtensionHolderPage extends Page
{
}
class ExtensionHolderPage_Controller extends Page_Controller
{

    public $addContent;
    public $afterEditContent;
    public $latestReleasePackage;
    public $extensionName;
    public $mailData;
    public $extensionType;
    public $disqus;

    public function init()
    {
        parent::init();
        Requirements::themedCSS("site");
        $this->disqus = file_get_contents(BASE_PATH.DIRECTORY_SEPARATOR.'extensionmanager/thirdparty/disqus.js');
        Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
        Requirements::javascript('themes/AddOns-Theme/bootstrap/js/bootstrap-tab.js');
    }

    /**
     * Setting up the form.
     *
     * @return Form .
     */
    public function AddForm($extensionType)
    {

        //if(!Member::currentUser()) return Security::permissionFailure();

        $fields = new FieldList(
            new TextField('Url', "Read-Only Url of your $extensionType Repository")
            );
        $actions = new FieldList(
            new FormAction('submitUrl', "Submit $extensionType")
            );
        $validator = new RequiredFields('URL');
        return new Form($this, 'AddForm', $fields, $actions, $validator);
    }

    /**
     * The form handler.
     */
    public function submitUrl($data, $form)
    {
        $url = $data['Url'];
        if (empty($url)) {
            $form->sessionMessage(_t('ExtensionHolderPage.BADURL', 'Please enter URL'), 'bad');
            return $this->redirectBack();
        } elseif (substr($url, 0, 4) != "http" && substr($url, 0, 3) != "git") {
            $form->sessionMessage(_t('ExtensionHolderPage.BADURL', "Please enter valid 'HTTP' or 'GIT Read-only' URL "), 'bad');
            return $this->redirectBack();
        } elseif (substr($url, 0, 4) == "git@") {
            $form->sessionMessage(_t('ExtensionHolderPage.BADURL', "'SSH' URL is not allowed, Please enter valid 'HTTP' or 'GIT Read-only' URL"), 'bad');
            return $this->redirectBack();
        }

        $json = new JsonHandler($url);
        $jsonData = $json->cloneJson();

        if (!array_key_exists('ErrorMsg', $jsonData)) {
            $this->latestReleasePackage = $jsonData['LatestRelease'];
            if ($this->isNewExtension($url)) {
                $saveJson = $json->saveJson();
                if (!array_key_exists('ErrorMsg', $saveJson)) {
                    $id = $saveJson['ExtensionID'];
                    $saveVersion = $json->saveVersionData($id);
                    if ($saveVersion) {
                        $this->extensionType = ExtensionData::get()->byID($id)->Type;
                        $this->extensionName = ExtensionData::get()->byID($id)->Name;

                        $this->mailData = array(
                            'ExtensionType' => $this->extensionType,
                            'ExtensionName' => $this->extensionName,
                            'SubmittedByName' => Member::currentUser()->Name,
                            'SubmittedByEmail' => Member::currentUser()->Email,
                            'ReviewAtUrl' => Director::absoluteBaseURL().'admin/extensions/ExtensionData/EditForm/field/ExtensionData/item/'.$id.'/edit',
                            'DetailPageLink' => Director::absoluteBaseURL().strtolower($this->extensionType).'/show/'.$id,
                            'Subject' => 'New '.$this->extensionType." '".$this->extensionName."' ".' Submitted',
                            );

                        $this->sendMailtoAdmin();

                        $form->sessionMessage(_t('ExtensionHolderPage.THANKSFORSUBMITTING', 'Thank you for submitting "'.$this->extensionName.'" '.$this->extensionType), 'good');
                        return $this->redirectBack();
                    }
                } else {
                    $form->sessionMessage(_t(
                        'ExtensionHolderPage.PROBLEMINSAVING', "We are unable to save Extension info, the parser reports: {$saveJson['ErrorMsg']} Please Re-check format of you composer.json file."), 'bad');
                    return $this->redirectBack();
                }
            } else {
                $updateJson = $json->updateJson();
                if (!array_key_exists('ErrorMsg', $updateJson)) {
                    $id = $updateJson['ExtensionID'];
                    $deleteVersion = $json->deleteVersionData($id);
                    if ($deleteVersion) {
                        $saveVersion = $json->saveVersionData($id);
                        if ($saveVersion) {
                            $this->extensionType = ExtensionData::get()->byID($id)->Type;
                            $this->extensionName = ExtensionData::get()->byID($id)->Name;

                            $this->mailData = array(
                                'ExtensionType' => $this->extensionType,
                                'ExtensionName' => $this->extensionName,
                                'SubmittedByName' => Member::currentUser()->Name,
                                'SubmittedByEmail' => Member::currentUser()->Email,
                                'ReviewAtUrl' => Director::absoluteBaseURL().'admin/extensions/ExtensionData/EditForm/field/ExtensionData/item/'.$id.'/edit',
                                'DetailPageLink' => Director::absoluteBaseURL().strtolower($this->extensionType).'/show/'.$id,
                                'Subject' => $this->extensionType." '".$this->extensionName."' ".' Updated',
                                );

                            $this->sendMailtoAdmin();

                            $form->sessionMessage(_t('ExtensionHolderPageExtensionHolderPage.THANKSFORUPDATING', 'Thank you for Updating your "'.$this->extensionName.'" '.$this->extensionType), 'good');
                            return $this->redirectBack();
                        }
                    } else {
                        $form->sessionMessage(_t('ExtensionHolderPage.PROBLEMINSAVING', 'Something went wrong we are not able to save versions of submitted extension '), 'bad');
                        return $this->redirectBack();
                    }
                } else {
                    $form->sessionMessage(_t('ExtensionHolderPage.PROBLEMINUPDATING', "We had problems parsing your composer.json file, the parser reports: {$updateJson['ErrorMsg']} Please read our extension Submission Guide for more details and submit url again"), 'bad');
                    return $this->redirectBack();
                }
            }
        } else {
            $form->sessionMessage(_t('ExtensionHolderPage.NOJSON', "We had problems parsing your composer.json file, the parser reports: {$jsonData['ErrorMsg']} Please read our extension Submission Guide for more details and submit url again"), 'bad');
            return $this->redirectBack();
        }
    }

    /**
      * Check if submitted module is new or old
      *
      * @param string $url
      * @return boolean
      */
    private function isNewExtension($url)
    {
        $extension = ExtensionData::get()->filter(array(
            // should we use url or title for checking existing module ?
            //"Url" => "$url"
            "Title" => $this->latestReleasePackage->getPrettyName()
            ))->First();
        if (!$extension) {
            return true;
        } else {
            return false;
        }
    }

    /**
      * Sending mail after extension submission/update.
      *
      */
    private function sendMailtoAdmin()
    {
        $From = $this->mailData['SubmittedByEmail'] ;
        $To = Config::inst()->get($this->mailData['ExtensionType'], 'ReviewerEmail');
        $Subject = $this->mailData['Subject'];
        $email = new Email($From, $To, $Subject);
        $email->setTemplate('ExtensionSubmitted');
        $email->populateTemplate($this->mailData);
        $email->send();
    }

    /**
      * Create Extension search form based on type of Extension.
      *
      * @return boolean $form
      */
    public function extensionSearch()
    {
        $context = singleton('ExtensionData')->getCustomSearchContext();
        $fields = $context->getSearchFields();
        $form = new Form($this, "extensionSearch",
            $fields,
            new FieldList(
                new FormAction('doSearch', "Search $this->extensionType")
                )
            );
        $form->setFormMethod('GET');
        $form->disableSecurityToken();
        return $form;
    }

    /**
      * Search Form action.
      *
      * @param array $data, $form
      * @return array
      */
    public function doSearch($data, $form)
    {
        $isFormSubmitted  = (isset($data['action_doSearch']) && ($data['action_doSearch'] == "Search $this->extensionType")) ? true : false ;
        $context = singleton('ExtensionData')->getCustomSearchContext();
        $results = $context->getResults($data)->filter(array(
            'Type' => $this->extensionType,
            'Accepted' => '1'
            ));
        return $this->customise(array(
            'FormSubmitted' => $isFormSubmitted,
            'ExtensionSearchResults' => $results,
            'SearchTitle' => _t('SearchForm.SearchResults', 'Search Results')
            ));
    }

    /**
      * Display 10 recently submitted Extensions.
      *
      * @return array
      */
    public function newExtension()
    {
        return ExtensionData::get()->filter(array(
            'Accepted' => '1',
            'Type' => $this->extensionType,
            ))->sort('Created', 'DESC')->limit('10');
    }

    /**
      * Return Javascript code for Discus.
      *
      * @return string
      */
    public function Disqus()
    {
        if ($this->disqus) {
            return $this->disqus;
        }
    }
}
