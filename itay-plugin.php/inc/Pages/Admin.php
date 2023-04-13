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

    $this->setSettings();
    $this->setSections();
    $this->setFields();

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
  public function setSettings() {
    $args = array(
      array(
        'option_group' => 'itay_options_group',
        'option_name' => 'text_example',
        'callback' => array($this->callbacks, 'itayOptionsGroup')
      ),
    );
    $this->settings->setSettings($args);
  }
  public function setSections() {
    $args = array(
      array(
        'id' => 'itay_admin_index',
        'title' => 'Settings',
        'callback' => array($this->callbacks, 'itayAdminSection'),
        'page' => 'itay_plugin',
      ),
    );
    $this->settings->setSections($args);
  }
  public function setFields() {
    $args = array(
      array(
        'id' => 'text_example',
        'title' => 'Text Example',
        'callback' => array($this->callbacks, 'itayTextExample'),
        'page' => 'itay_plugin',
        'section' => 'itay_admin_index',
        'args' => array(
          'label_for' => 'text_example',
          'class' => 'example-class',
        ),
      ),
    );
    $this->settings->setFields($args);
  }
}
// i am taliya shaul and i love itay but just little ok?