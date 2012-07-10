# Getting started with SilverStripe's Extension Manager Module 

## Requirements

 * silverstripe 3.0
 * composer [https://github.com/composer/composer]

## Installation

To install this module:

1. Either clone the code from the GitHub repository with ``git clone git@github.com:vikas-srivastava/extensionmanager.git `` or download it at [https://github.com/vikas-srivastava/extensionmanager/downloads](https://github.com/vikas-srivastava/extensionmanager/downloads).
2. Add the folder to your SilverStripe installation and rename it to ``extensionmanager``.
3. Access ``/dev/build/?flush=all`` to install the module.
4. Go to root of module ``cd path/to/extensionmanager``
5. Install composer binary with ``curl -s http://getcomposer.org/installer | php`` .[https://github.com/composer/composer#composer---package-management-for-php](see here for global installation)
6. Run following command for installing dependencies of this module ``composer.phar install``