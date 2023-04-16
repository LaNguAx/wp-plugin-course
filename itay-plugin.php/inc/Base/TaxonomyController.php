<?php

/**
 * @package ItayPlugin
 */

namespace Inc\Base;

use Inc\Api\SettingsApi;
use \Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class TaxonomyController extends BaseController {

  public $settings;
  public $callbacks;
  public $subpage = array();

  public function register() {
    if (!$this->managerActive('taxonomy_manager')) return;

    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();

    $this->setSubpage();
    $this->settings->addSubPages($this->subpage)->register();

    add_action('init', array($this, 'activate'));
  }

  public function activate() {
    echo 'working';
  }

  public function setSubpage() {
    $this->subpage = array(
      [
        'parent_slug' => 'itay_plugin',
        'page_title' => 'Taxonomy Manager',
        'menu_title' => 'Taxonomy Manager',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_taxonomy',
        'callback' => array($this->callbacks, 'taxonomyManager'),
      ]
    );
  }
}
