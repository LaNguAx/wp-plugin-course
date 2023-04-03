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


class ItayPlugin {

  function __construct() {
    add_action('init', array($this, 'custom_post_type'));
  }
  function activate() {
    // Generate CPT
    $this->custom_post_type();
    // Flush re-write rules
    flush_rewrite_rules();
  }
  function deactivate() {
    flush_rewrite_rules();
  }
  static function uninstall() {
  }
  function custom_post_type() {
    register_post_type('book', array('public' => true, 'label' => 'Books'));
  }

  function register() {
    add_action('admin_enqueue_scripts', array($this, 'enqueue'));
  }
  function enqueue() {
    //enqueue all of our scripts.
    wp_enqueue_style('mypluginstyle', plugin_dir_url(__FILE__) . '/assets/mystyle.css');
    wp_enqueue_script('mypluginscript', plugin_dir_url(__FILE__) . '/assets/myscript.js');
  }
}

if (class_exists('ItayPlugin')) {
  $itayPlugin = new ItayPlugin('Itay Plugin initialized!');
  $itayPlugin->register();
}

// Activation
register_activation_hook(__FILE__, array($itayPlugin, 'activate'));

// DeActivation
register_deactivation_hook(__FILE__, array($itayPlugin, 'deactivate'));

// Uninstall
//View uninstall file.