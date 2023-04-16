<?php


/**
 * 
 * @package itay_plugin
 * 
 */

namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class MediaWidgetController extends BaseController {

  public $settings;
  public $callbacks;
  public $subpage = array();

  public function register() {
    if (!$this->managerActive('media_widget')) return;

    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();

    $this->setSubpage();
    $this->settings->addSubPages($this->subpage)->register();
  }
  public function setSubpage() {
    $subpage = array(
      [
        'parent_slug' => 'itay_plugin',
        'page_title' => 'Media Widget Manager',
        'menu_title' => 'Media Widget',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_widgets',
        'callback' => array($this->callbacks, 'widgetsManager')
      ]
    );
    $this->subpage = $subpage;
  }
}
