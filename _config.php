<?php
require_once __DIR__ . '/vendor/autoload.php';

FulltextSearchable::enable();

Object::add_extension('Member', 'ExtensionsMemberDecorator');

Director::addRules(100, array(
    'module' => 'Module_Controller'
));

Director::addRules(100, array(
    'theme' => 'Theme_Controller'
));