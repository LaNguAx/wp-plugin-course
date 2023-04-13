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

  public function register() {
    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();
    $this->callbacks_manager = new ManagerCallbacks();
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
        'option_group' => 'itay_plugin_settings',
        'option_name' => 'cpt_manager',
        'callback' => array($this->callbacks_manager, 'checkboxSanitize')
      ),
      array(
        'option_group' => 'itay_plugin_settings',
        'option_name' => 'taxonomy_manager',
        'callback' => array($this->callbacks_manager, 'checkboxSanitize')
      ), array(
        'option_group' => 'itay_plugin_settings',
        'option_name' => 'media_widget',
        'callback' => array($this->callbacks_manager, 'checkboxSanitize')
      ),
      array(
        'option_group' => 'itay_plugin_settings',
        'option_name' => 'gallery_manager',
        'callback' => array($this->callbacks_manager, 'checkboxSanitize')
      ),
      array(
        'option_group' => 'itay_plugin_settings',
        'option_name' => 'testimonial_manager',
        'callback' => array($this->callbacks_manager, 'checkboxSanitize')
      ),
      array(
        'option_group' => 'itay_plugin_settings',
        'option_name' => 'template_manager',
        'callback' => array($this->callbacks_manager, 'checkboxSanitize')
      ),
      array(
        'option_group' => 'itay_plugin_settings',
        'option_name' => 'login_manager',
        'callback' => array($this->callbacks_manager, 'checkboxSanitize')
      ),
      array(
        'option_group' => 'itay_plugin_settings',
        'option_name' => 'membership_manager',
        'callback' => array($this->callbacks_manager, 'checkboxSanitize')
      ),
      array(
        'option_group' => 'itay_plugin_settings',
        'option_name' => 'chat_manager',
        'callback' => array($this->callbacks_manager, 'checkboxSanitize')
      ),
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
    $args = array(
      array(
        'id' => 'cpt_manager',
        'title' => 'Activate CPT Manager',
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'itay_plugin',
        'section' => 'itay_admin_index',
        'args' => array(
          'label_for' => 'cpt_manager',
          'class' => 'ui-toggle'
        ),
      ),
      array(
        'id' => 'taxonomy_manager',
        'title' => 'Activate Taxonomy Manager',
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'itay_plugin',
        'section' => 'itay_admin_index',
        'args' => array(
          'label_for' => 'taxonomy_manager',
          'class' => 'ui-toggle'
        ),
      ),
      array(
        'id' => 'media_widget',
        'title' => 'Activate Media Widget',
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'itay_plugin',
        'section' => 'itay_admin_index',
        'args' => array(
          'label_for' => 'media_widget',
          'class' => 'ui-toggle'
        )
      ),
      array(
        'id' => 'gallery_manager',
        'title' => 'Activate Gallery Manager',
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'itay_plugin',
        'section' => 'itay_admin_index',
        'args' => array(
          'label_for' => 'gallery_manager',
          'class' => 'ui-toggle'
        ),
      ),
      array(
        'id' => 'testimonial_manager',
        'title' => 'Activate Testimonial Manager',
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'itay_plugin',
        'section' => 'itay_admin_index',
        'args' => array(
          'label_for' => 'testimonial_manager',
          'class' => 'ui-toggle'
        ),
      ),
      array(
        'id' => 'templates_manager',
        'title' => 'Activate Templates Manager',
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'itay_plugin',
        'section' => 'itay_admin_index',
        'args' => array(
          'label_for' => 'templates_manager',
          'class' => 'ui-toggle'
        ),
      ),
      array(
        'id' => 'login_manager',
        'title' => 'Activate Login Manager',
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'itay_plugin',
        'section' => 'itay_admin_index',
        'args' => array(
          'label_for' => 'login_manager',
          'class' => 'ui-toggle'
        ),
      ),
      array(
        'id' => 'membership_manager',
        'title' => 'Activate Membership Manager',
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'itay_plugin',
        'section' => 'itay_admin_index',
        'args' => array(
          'label_for' => 'membership_manager',
          'class' => 'ui-toggle'
        ),
      ),
      array(
        'id' => 'chat_manager',
        'title' => 'Activate Chat Manager',
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'itay_plugin',
        'section' => 'itay_admin_index',
        'args' => array(
          'label_for' => 'chat_manager',
          'class' => 'ui-toggle'
        ),
      ),

    );
    $this->settings->setFields($args);
  }
}
// i am taliya shaul and i love itay but just little ok?