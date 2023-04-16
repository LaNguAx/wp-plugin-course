<?php

/**
 * @package ItayPlugin
 */

namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class TemplatesController extends BaseController {
  public object $settings;
  public object $callbacks;
  public array $subpage = array();

  public function register() {
    if (!$this->managerActive('templates_manager')) return;

    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();

    $this->setSubpage();
    $this->settings->addSubPages($this->subpage)->register();
  }

  public function setSubpage() {
    $this->subpage = array(
      [
        'parent_slug' => 'itay_plugin',
        'page_title' => 'Templates Manager',
        'menu_title' => 'Templates Manager',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_templates',
        'callback' => array($this->callbacks, 'templatesManager'),
      ]
    );
  }
}
