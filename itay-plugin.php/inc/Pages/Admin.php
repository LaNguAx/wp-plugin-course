<?php


/**
 * @package ItayPlugin
 */

namespace Inc\Pages;

use Templates\Admin;

class AdminPages {
  public function __construct() {
  }
  public static function settings_link($links) {
    // add custom plugin link
    $settings_link = '<a href="admin.php?page=itay_plugin">Settings</a>';
    array_push($links, $settings_link);
    return $links;
  }
  public static function add_admin_pages() {
    // Manage options is saying that only an administrator can access this page.
    // Always write slugs with underscores
    add_menu_page('Itay Plugin', 'ItayPL', 'manage_options', 'itay_plugin', Admin::admin_index(), 'dashicons-store', 110);
  }
  // public function admin_index() {
  //   // require_once plugin_dir_path(__FILE__) . 'admin_index';
  //   Admin::admin_index();
  // }
}
