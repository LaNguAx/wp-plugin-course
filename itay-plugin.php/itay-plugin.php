<?php


/**
 * @package ItayPlugin
 */


/*
Plugin Name: Itay Plugin
Plugin URI: https://github.com/LaNguAx/wp-plugin-course
Description: This is my first attempt on writing a custom Plugin for this amazing tutorial series.
Version: 1.0.0
Author: Itay Aknin
Author URI: https://www.linkedin.com/in/itay-aknin-aa5691270/
License: GPLv2
Text Domain: itay-plugin
*/

defined('ABSPATH') or die('Hey, you can\t access this file, you silly human!');

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
  require_once dirname(__FILE__) . '/vendor/autoload.php';
}

function activate_itay_plugin() {
  Inc\Base\Activate::activate();
}
register_activation_hook(__FILE__, 'activate_itay_plugin');

function deactivate_itay_plugin() {
  Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_itay_plugin');

if (class_exists('Inc\\Init')) {
  Inc\Init::register_services();
}
