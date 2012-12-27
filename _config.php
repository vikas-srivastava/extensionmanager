<?php

/**
  * Autoloading composer classes.
  */
require_once __DIR__ . '/vendor/autoload.php';

//todo add better search
FulltextSearchable::enable();

/**
  * Url rule for handling module pages.
  */
Director::addRules(100, array(
    'module' => 'Module_Controller'
));

/**
  * Url rule for handling theme pages.
  */
Director::addRules(100, array(
    'theme' => 'Theme_Controller'
));

/**
  * Url rule for handling widget pages.
  */
Director::addRules(100, array(
    'widget' => 'Widget_Controller'
));