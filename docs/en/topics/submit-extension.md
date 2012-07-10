# Submit New Extension

Each Extension Holder page contains link to form submission. Following step required for listing a new module on our website.

![Create Page](https://github.com/vikas-srivastava/extensionmanager/raw/master/docs/img/module-page.png)

By submitting read-only address of repository we are fetching all the information of [composer.json](https://github.com/vikas-srivastava/demo_composer_module/blob/master/composer.json#L1) file placed in root of module directory using [composer](https://github.com/composer/composer). Along with content of composer.json we are also fetching data of all orher versions.

![Extension submission form](https://github.com/vikas-srivastava/extensionmanager/raw/master/docs/img/module-submission-form.png)

After sucessfull submission we are getting this form messeage.

![Module submitted](https://github.com/vikas-srivastava/extensionmanager/raw/master/docs/img/module-submitted.png)

But recently submitted module is not appearing becuase its yet not accepted.

![Module listing](https://github.com/vikas-srivastava/extensionmanager/raw/master/docs/img/not-listing-newly-submitted- module.png)

For approving module we need to check approved field in Model Admin of ExtensionData.

![Model Admin](https://github.com/vikas-srivastava/extensionmanager/raw/master/docs/img/model-admin-for-extension-data.png)

![Model Admin](https://github.com/vikas-srivastava/extensionmanager/raw/master/docs/img/approving-extension.png)

Now approved module is appearing on module listing.
![Module listing](https://github.com/vikas-srivastava/extensionmanager/raw/master/docs/img/listing-of-approved-modules.png)

Similar steps are required for all other types of extensions (Theme/Widget).

### 	[Previous](https://github.com/vikas-srivastava/extensionmanager/blob/master/docs/en/topics/add-search-pages.md)		[Next](https://github.com/vikas-srivastava/extensionmanager/blob/master/docs/en/topics/detail-module-page.md)