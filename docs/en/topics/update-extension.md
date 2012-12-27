# Update Extension

Update of extension can be done in either of two methods.

## 1. Using Extension Submission Form

 By submitting url of repository again in respective extension submission form. Module will detect [automatically](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/page_type/ExtensionHolder.php#L85) whether it is new module or old one. If module is already submitted form handler will run update function for old extensions.

![Extension submission form](https://github.com/vikas-srivastava/extensionmanager/raw/master/docs/img/module-update-form.png)

![Extension submission form](https://github.com/vikas-srivastava/extensionmanager/raw/master/docs/img/update-by-form.png)

## 2. By Running scheduled task.

We have created one scheduled task class [JsonUpdateTask](https://github.com/vikas-srivastava/extensionmanager/blob/master/code/task/JsonUpdateTask.php#L1) which can be run manually or by using cron job.

![Extension submission form](https://github.com/vikas-srivastava/extensionmanager/raw/master/docs/img/update-by-cron.png)

### 	[Previous](https://github.com/vikas-srivastava/extensionmanager/blob/master/docs/en/topics/detail-module-page.md)