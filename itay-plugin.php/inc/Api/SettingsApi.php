<?php

/**
 * @package ItayPlugin
 */

namespace Inc\Api;

class SettingsApi {

  public $admin_pages = array();
  public $admin_subpages = array();

  public $settings = array();
  public $sections = array();
  public $fields = array();

  public function register() {
    if (!empty($this->admin_pages) || !empty($this->admin_subpages))
      add_action('admin_menu', array($this, 'addAdminMenu'));
    if (!empty($this->settings))
      add_action('admin_init', array($this, 'registerCustomFields'));
  }

  public function addPages(array $pages) {
    $this->admin_pages = $pages;
    return $this;
  }


  public function withSubPage(string $title = null) {
    if (empty($this->admin_pages))
      return $this;

    $admin_page = $this->admin_pages[0];
    $subpage = array(
      [
        'parent_slug' => $admin_page['menu_slug'],
        'page_title' => $admin_page['page_title'],
        'menu_title' => ($title) ? $title : $admin_page['menu_title'],
        'capability' => $admin_page['capability'],
        'menu_slug' => $admin_page['menu_slug'],
        'callback' => $admin_page['callback'],
      ],
    );
    $this->admin_subpages = array_merge($this->admin_subpages, $subpage);
    return $this;
  }

  public function addSubPages(array $pages) {
    $this->admin_subpages = array_merge($this->admin_subpages, $pages);
    return $this;
  }

  public  function addAdminMenu() {
    foreach ($this->admin_pages as $page) {
      add_menu_page($page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position']);
    }
    foreach ($this->admin_subpages as $subpage) {
      add_submenu_page($subpage['parent_slug'], $subpage['page_title'], $subpage['menu_title'], $subpage['capability'], $subpage['menu_slug'], $subpage['callback']);
    }
  }
  public function setSettings(array $settings) {
    $this->settings = $settings;
    return $this;
  }
  public function setSections(array $sections) {
    $this->sections = $sections;
    return $this;
  }
  public function setFields(array $fields) {
    $this->fields = $fields;
    return $this;
  }

  public function registerCustomFields() {
    // Register_setting
    register_setting($this->settings['option_group'], $this->settings['option_name'], isset($this->settings['callback']) ? $this->settings['callback'] : null);

    foreach ($this->sections as $section) {
      // Add settings section
      add_settings_section($section['id'], $section['title'], isset($section['callback']) ? $section['callback'] : null, $section['page']);
    }

    foreach ($this->fields as $field) {
      // Add settings field
      add_settings_field($field['id'], $field['title'], isset($field['callback']) ? $field['callback'] : null, $field['page'], $field['section'], isset($field['args']) ? $field['args'] : '');
    }
  }
}
