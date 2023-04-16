<?php


/**
 * @package ItayPlugin
 */

namespace Inc\Pages;

use \Inc\Api\SettingsApi;
use \Inc\Base\BaseController;
use \Inc\Api\Callbacks\AdminCallbacks;
use \Inc\Api\Callbacks\ManagerCallbacks;


class Dashboard extends BaseController {

  public $settings;
  public $callbacks;
  public $callbacks_manager;
  public $pages = array();
  // public $subpages = array();

  public $settings_data;


  public function register() {
    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();
    $this->callbacks_manager = new ManagerCallbacks();
    $this->setPages();

    $this->setSettings();
    $this->setSections();
    $this->setFields();

    $this->settings->addPages($this->pages)->withSubPage('Dashboard')->register();
  }
  public function setPages() {
    $pages = array(
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
    $this->pages = $pages;
  }

  public function setSettings() {
    // To insert serialized data we create one entry and populate it using serialized data.
    $args = array(
      'option_group' => 'itay_plugin_settings',
      'option_name' => 'itay_plugin',
      'callback' => array($this->callbacks_manager, 'checkboxSanitize')
    );
    $this->settings->setSettings($args);
  }

  public function setSections() {
    $args = array(
      array(
        'id' => 'itay_admin_index',
        'title' => 'Settings Manager',
        'callback' => array($this->callbacks_manager, 'adminSectionManager'),
        'page' => 'itay_plugin',
      ),
    );
    $this->settings->setSections($args);
  }

  public function setFields() {
    // Teacher's code
    $args = array();
    foreach ($this->managers as $key => $value) {
      $args[] =  array(
        'id' => $key,
        'title' => $value,
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'itay_plugin',
        'section' => 'itay_admin_index',
        'args' => array(
          'option_name' => 'itay_plugin',
          'label_for' => $key,
          'class' => 'ui-toggle',
        ),
      );
    }

    $this->settings->setFields($args);
  }
}
// i am taliya shaul and i love itay but just little ok?