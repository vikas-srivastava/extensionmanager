# Data Flow Between Classes 

 Data flow between classes can be explained by the following block-diagram of classes.

 ![Data Flow](https://github.com/vikas-srivastava/extensionmanager/raw/master/docs/img/data-flow.png)

## Store Data

 Step 1 - User submits Url in [Form](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/page_type/ExtensionHolder.php#L22) of their Module Repository using [ModuleHolder](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/page_type/ModuleHolder.php) Page which is extended from [ExtensionHolder](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/page_type/ExtensionHolder.php) Page class.

 Step 2 - Form action first confirms if module is new or author is updating his module then it creates object of [JsonHandler](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/control/JsonHandler.php) class and calls [cloneJson](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/control/JsonHandler.php#L32) function with submitted url as parameter. 

 Step 3 & 4 - cloneJson function in JsonHandler class passes submitted url to Composer system which returns data of all versions as an object.

 Step 5 - After some filtering JsonHandler returns array of packages containing Latest master branch package object and all versions object.

 Step 6 - ExtensionHolder class then passes this data to [saveJson](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/control/JsonHandler.php#L95) function of JsonHandler class.

 Step 7 - saveJson function first stores all the data in respective fields of [ExtensionData](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/control/ExtensionData.php) class and checks if all the required fields are available in composer.json file of submitted module.

 Step 9,10,11,12,13 - saveJson function then stores data in [related tables](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/control/ExtensionData.php#L89) of ExtensionData class like [versions](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/control/ExtensionVersion.php) , [keywords](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/control/ExtensionKeywords.php), [authors info](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/control/ExtensionAuthorController.php), [snapshot](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/control/ExtensionSnapshot.php), of module. 

 Step 14,15,16 - After successfull submission it sends mail about new submission to module moderators and displays submitted/updated message to user.

 ## Fetch Data 

 Step A & B - [show()](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/control/ExtensionData.php#L197) function in ExtensionData class which is responible for providing data to [Module_show](https://github.com/vikas-srivastava/extensionmanager/blob/master/templates/Layout/Module_show.ss),[theme_show](https://github.com/vikas-srivastava/extensionmanager/blob/master/templates/Layout/Theme_show.ss), [widget_show](https://github.com/vikas-srivastava/extensionmanager/blob/master/templates/Layout/Widget_show.ss) templates. By using some [Url Rules](https://github.com/vikas-srivastava/extensionmanager/blob/master/_config.php#L16) show() function provides data to these templates on load of [Module](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/page_type/Module.php),[Theme](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/page_type/Theme.php),[Widgets](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/page_type/Widget.php) classes.