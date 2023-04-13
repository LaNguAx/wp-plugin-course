<?php


/**
 * @package ItayPlugin
 */

namespace Inc\Pages;

use \Inc\Api\SettingsApi;
use \Inc\Base\BaseController;
use \Inc\Api\Callbacks\AdminCallbacks;

class Admin extends BaseController {

  public $settings;
  public $callbacks;
  public $pages = array();
  public $subpages = array();

  public function register() {
    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();
    $this->setPages();
    $this->setSubPages();

    $this->settings->addPages($this->pages)->withSubPage('Dashboard')->addSubPages($this->subpages)->register();
  }
  public function setPages() {
    $this->pages = array(
      [
        'page_title' => 'Itay Plugin',
        'menu_title' => 'ItayPL',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_plugin',
        'callback' => array($this->callbacks, 'adminDashboard'),
        'icon_url' => 'dashicons-store',
        'position' => 110
      ],
    );
  }
  public function setSubPages() {
    $this->subpages = array(
      [
        'parent_slug' => 'itay_plugin',
        'page_title' => 'Custom Post Types',
        'menu_title' => 'CPT',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_cpt',
        'callback' => array($this->callbacks, 'cptManager'),
      ], [
        'parent_slug' => 'itay_plugin',
        'page_title' => 'Custom Taxonomies',
        'menu_title' => 'Taxonomies',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_taxonomies',
        'callback' => array($this->callbacks, 'taxonomyManager'),
      ], [
        'parent_slug' => 'itay_plugin',
        'page_title' => 'Custom Widgets',
        'menu_title' => 'Widgets',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_widgets',
        'callback' => array($this->callbacks, 'widgetsManager'),
      ],
    );
  }
}
// i am taliya shaul and i love itay but just little ok?