<?php


/**
 * @package ItayPlugin
 */

namespace Inc\Pages;

use \Inc\Api\SettingsApi;
use \Inc\Base\BaseController;
use \Inc\Api\Callbacks\AdminCallbacks;
use \Inc\Api\Callbacks\ManagerCallbacks;


class Admin extends BaseController {

  public $settings;
  public $callbacks;
  public $callbacks_manager;
  public $pages = array();
  public $subpages = array();

  public $settings_data;


  public function register() {
    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();
    $this->callbacks_manager = new ManagerCallbacks();
    $this->setPages();
    $this->setSubPages();

    $this->generateSettingsData();

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

  public function generateSettingsData() {
    $this->settings_data = $this->settings_data = array(
      array(
        'setting_name' => 'cpt_manager',
        'setting_title' => 'Activate CPT Manager'
      ),
      array(
        'setting_name' => 'taxonomy_manager',
        'setting_title' => 'Activate Taxonomy Manager'
      ),
      array(
        'setting_name' => 'media_widget',
        'setting_title' => 'Activate Media Widget'
      ),
      array(
        'setting_name' => 'gallery_manager',
        'setting_title' => 'Activate Gallery Manager'
      ),
      array(
        'setting_name' => 'testimonial_manager',
        'setting_title' => 'Activate Testimonial Manager'
      ),
      array(
        'setting_name' => 'template_manager',
        'setting_title' => 'Activate Template Manager'
      ),
      array(
        'setting_name' => 'login_manager',
        'setting_title' => 'Activate Login Manager'
      ),
      array(
        'setting_name' => 'membership_manager',
        'setting_title' => 'Activate Membership Manager'
      ),
      array(
        'setting_name' => 'chat_manager',
        'setting_title' => 'Activate Chat Manager'
      ),
    );
  }

  public function setSettings() {
    // $args = array_map(function ($element) {
    //   return array(
    //     'option_group' => 'itay_plugin_settings',
    //     'option_name' => $element['setting_name'],
    //     'callback' => array($this->callbacks_manager, 'checkboxSanitize')
    //   );
    // }, $this->settings_data);
    // $this->settings->setSettings($args);

    // Teacher's code
    // $args = array();
    // foreach ($this->managers as $key =>  $value) {
    //   // This [] is to inject a new array inside an array.
    //   // By doing this we are injecting inside a new slot in the array, if we are not specifying [] we are going to over-ride the array.
    //   $args[] = array(
    //     'option_group' => 'itay_plugin_settings',
    //     'option_name' => $key,
    //     'callback' => array($this->callbacks_manager, 'checkboxSanitize')
    //   );
    // }

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
    // $argss = array_map(function ($element) {
    //   return  array(
    //     'id' => $element['setting_name'],
    //     'title' => $element['setting_title'],
    //     'callback' => array($this->callbacks_manager, 'checkboxField'),
    //     'page' => 'itay_plugin',
    //     'section' => 'itay_admin_index',
    //     'args' => array(
    //       'label_for' => $element['setting_name'],
    //       'class' => 'ui-toggle'
    //     ),
    //   );
    // }, $this->settings_data);
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