<?php


/**
 * @package ItayPlugin
 */

namespace Inc\Pages;

use \Inc\Base\BaseController;
use \Inc\Api\SettingsApi;

class Admin extends BaseController {

  public $settings;
  public $pages = array();
  public $subpages = array();

  public function __construct() {
    $this->settings = new SettingsApi();
    $this->pages = array(
      [
        'page_title' => 'Itay Plugin',
        'menu_title' => 'ItayPL',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_plugin',
        'callback' => function () {
          echo '<h1>Itay Plugin Manager</h1>';
        },
        'icon_url' => 'dashicons-store',
        'position' => 110
      ],
    );
    $this->subpages = array(
      [
        'parent_slug' => 'itay_plugin',
        'page_title' => 'Custom Post Types',
        'menu_title' => 'CPT',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_cpt',
        'callback' => function () {
          echo '<h1>Custom Post Types Manager</h1>';
        },
      ], [
        'parent_slug' => 'itay_plugin',
        'page_title' => 'Custom Taxonomies',
        'menu_title' => 'Taxonomies',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_taxonomies',
        'callback' => function () {
          echo '<h1>Taxonomy Manager</h1>';
        },
      ], [
        'parent_slug' => 'itay_plugin',
        'page_title' => 'Custom Widgets',
        'menu_title' => 'Widgets',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_widgets',
        'callback' => function () {
          echo '<h1>Widgets Manager</h1>';
        },
      ],
    );
  }
  public function register() {
    $this->settings->addPages($this->pages)->withSubPage('Dashboard')->addSubPages($this->subpages)->register();
  }
}
