# Getting started with SilverStripe's Extension Manager Module 

## Requirements

 * silverstripe 3.0
 * [composer](https://github.com/composer/composer)

## Installation

To install this module:

1. Either clone the code from the GitHub repository with ``git clone git@github.com:vikas-srivastava/extensionmanager.git `` or download at [Here](https://github.com/vikas-srivastava/extensionmanager/downloads).

2. Add the folder to your SilverStripe installation and rename it to ``extensionmanager``.

3. Go to root of module ``cd path/to/extensionmanager``.

4. Install composer binary with ``curl -s http://getcomposer.org/installer | php`` [see here for global installation](https://github.com/composer/composer#composer---package-management-for-php). 

5. Run following command for installing dependencies of this module ``php composer.phar install``.

6. Access ``/dev/build/?flush=all`` to install the module.