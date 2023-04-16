<?php

/**
 * @package ItayPlugin
 */

namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class LoginController extends BaseController {
  public $settings;
  public $callbacks;
  public $subpage = array();

  public function register() {
    if (!$this->managerActive('login_manager')) return;

    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();

    $this->setSubpage();
    $this->settings->addSubPages($this->subpage)->register();
  }

  public function setSubpage() {
    $this->subpage = array(
      [
        'parent_slug' => 'itay_plugin',
        'page_title' => 'Login Manager',
        'menu_title' => 'Login Manager',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_login',
        'callback' => array($this->callbacks, 'loginManager')
      ]
    );
  }
}
