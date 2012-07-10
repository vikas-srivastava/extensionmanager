# Submit New Extension

Each Extension Holder page contains link to form submission. Following step required for listing a new module on our website.

![Create Page](https://github.com/vikas-srivastava/extensionmanager/raw/doc/docs/img/module-page.png)

By submitting read-only address of repository we are fetching all the information of [composer.json](https://github.com/vikas-srivastava/demo_composer_module/blob/master/composer.json#L1) file placed in root of module directory using [composer](https://github.com/composer/composer). Along with content of composer.json we are also fetching data of all orher versions.

![Create Page](https://github.com/vikas-srivastava/extensionmanager/raw/doc/docs/img/module-submission-form.png)

After sucessfull submission we are getting this form messeage.

![Create Page](https://github.com/vikas-srivastava/extensionmanager/raw/doc/docs/img/module-submitted.png)

But recently submitted module is not appearing becuase its yet not accepted.

![Create Page](https://github.com/vikas-srivastava/extensionmanager/raw/doc/docs/img/not-listing-newly-submitted- module.png)

For approving module we need to check approved field in Model Admin of ExtensionData.

![Create Page](https://github.com/vikas-srivastava/extensionmanager/raw/doc/docs/img/model-admin-for-extension-data.png)

![Create Page](https://github.com/vikas-srivastava/extensionmanager/raw/doc/docs/img/approving-extension.png)

Now approved module is appearing on module listing.
![Create Page](https://github.com/vikas-srivastava/extensionmanager/raw/doc/docs/img/listing-of-approved-modules.png)