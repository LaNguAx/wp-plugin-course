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

  public function register() {
    add_action('admin_enqueue_scripts', array($this, 'enqueue'));
  }
  protected function create_post_type() {
    add_action('init', array($this, 'custom_post_type'));
  }

  function custom_post_type() {
    register_post_type('book', array('public' => true, 'label' => 'Books'));
  }

  function enqueue() {
    //enqueue all of our scripts.
    wp_enqueue_style('mypluginstyle', plugin_dir_path(__FILE__) . '/assets/mystyle.css');
    wp_enqueue_script('mypluginscript', plugin_dir_path(__FILE__) . '/assets/myscript.js');
  }

  function activate() {
    require_once plugin_dir_path(__FILE__) . 'inc/itay-plugin-activate.php';
    ItayPluginActivate::activate();
  }
}

if (class_exists('ItayPlugin')) {
  $itayPlugin = new ItayPlugin('Itay Plugin initialized!');
  $itayPlugin->register();
}



// Activation
register_activation_hook(__FILE__, array($itayPlugin, 'activate'));

// DeActivation
require_once plugin_dir_path(__FILE__) . 'inc/itay-plugin-deactivate.php';
register_deactivation_hook(__FILE__, array('ItayPluginDeactivate', 'deactivate'));

// Uninstall
//View uninstall file.