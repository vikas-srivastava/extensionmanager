# Detail Extension Page 

After approving Extension we can get a detail page for extension. For creating detail page we are using coustom controller for each extension type ( [Module](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/page_type/Module.php) / [widget](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/page_type/Widget.php) / [Theme](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/page_type/Theme.php)).

![Module listing](https://github.com/vikas-srivastava/extensionmanager/raw/master/docs/img/listing-of-approved-modules.png)

Using listed module link we can go to detail page.

![Detail Module page](https://github.com/vikas-srivastava/extensionmanager/raw/master/docs/img/detail-module-page.png)

### Subversion Data 

Using composer we can get detail of subversion and there gisturl.

![Detail Module page](https://github.com/vikas-srivastava/extensionmanager/raw/master/docs/img/subversion-data.png)


### Theme & Widget Pages

Right now we have similar data on themes/widgets pages but later we will modify them.

Theme Page: 

![Detail Module page](https://github.com/vikas-srivastava/extensionmanager/raw/master/docs/img/theme-page.png)

Widget Page: 

![Detail Module page](https://github.com/vikas-srivastava/extensionmanager/raw/master/docs/img/widget-page.png)

Detail pages are using [show()](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/page_type/Module.php#L32) function of controller and by writing few Url rule. Every detail page link looks like ``path/to/root/module/show/extensionId``.

### 	[Previous](https://github.com/vikas-srivastava/extensionmanager/blob/master/docs/en/topics/submit-extension.md)		[Next](https://github.com/vikas-srivastava/extensionmanager/blob/master/docs/en/topics/update-extension.md)