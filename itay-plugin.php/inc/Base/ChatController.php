<?php

/**
 * @package ItayPlugin
 */

namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class ChatController extends BaseController {
  public $settings;
  public $callbacks;
  public $subpage = array();

  public function register() {
    if (!$this->managerActive('chat_manager')) return;

    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();

    $this->setSubpage();
    $this->settings->addSubPages($this->subpage)->register();
  }

  public function setSubpage() {
    $this->subpage = array(
      [
        'parent_slug' => 'itay_plugin',
        'page_title' => 'Chat Manager',
        'menu_title' => 'Chat Manager',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_chat',
        'callback' => array($this->callbacks, 'chatManager')
      ]
    );
  }
}
