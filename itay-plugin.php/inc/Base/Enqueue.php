<?php

/**
 * @package ItayPlugin
 */

namespace Inc\Base;

use \Inc\Base\BaseController;

class Enqueue extends BaseController {
  public function register() {
    add_action('admin_enqueue_scripts', array($this, 'enqueue'));
  }
  function enqueue() {
    //enqueue all of our scripts.
    wp_enqueue_style('dashboardTabsStyle', $this->plugin_url . 'build/adminstyle.css');
    wp_enqueue_script('dashboardTabsScript', $this->plugin_url . 'build/tabs.js');
  }
}
