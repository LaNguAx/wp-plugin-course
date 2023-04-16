<?php

/**
 * @package itay_plugin
 */

namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class GalleryController extends AdminCallbacks {
  public object $settings;
  public object $callbacks;
  public $subpage = array();

  public function register() {
    if (!$this->managerActive('gallery_manager')) return;

    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();

    $this->setSubpage();
    $this->settings->addSubPages($this->subpage)->register();
  }
  public function setSubpage() {
    $subpage = array(
      [
        'parent_slug' => 'itay_plugin',
        'page_title' => 'Gallery Manager',
        'menu_title' => 'Gallery Manager',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_gallery',
        'callback' => array($this->callbacks, 'galleryManager')
      ]
    );
    $this->subpage = $subpage;
  }
}
