<?php

/**
 * @package ItayPlugin
 */

namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class MembershipController extends BaseController {
  public $settings;
  public $callbacks;
  public $subpage = array();

  public function register() {
    if (!$this->managerActive('membership_manager')) return;

    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();

    $this->setSubpage();
    $this->settings->addSubPages($this->subpage)->register();
  }

  public function setSubpage() {
    $this->subpage = array(
      [
        'parent_slug' => 'itay_plugin',
        'page_title' => 'Membership Manager',
        'menu_title' => 'Membership Manager',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_membership',
        'callback' => array($this->callbacks, 'membershipManager')
      ]
    );
  }
}
