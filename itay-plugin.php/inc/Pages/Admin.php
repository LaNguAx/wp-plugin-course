<?php


/**
 * @package ItayPlugin
 */

namespace Inc\Pages;

use \Inc\Base\BaseController;

class Admin extends BaseController {
  public function register() {
    add_action('admin_menu', array($this, 'add_admin_pages'));
  }
  public function add_admin_pages() {
    // Manage options is saying that only an administrator can access this page.
    // Always write slugs with underscores
    add_menu_page('Itay Plugin', 'ItayPL', 'manage_options', 'itay_plugin', array($this, 'admin_index'), 'dashicons-store', 110);
  }
  public function admin_index() {
    require_once $this->plugin_path .  '/templates/admin.php';
  }
}
