<?php

/**
 * @package ItayPlugin
 */

namespace Inc\Base;

use Inc\Api\SettingsApi;
use \Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class CustomPostTypeController extends BaseController {

  public $subpages = array();
  public $settings;
  public $callbacks;
  public $custom_post_types = array();

  public function register() {

    // $option = get_option('itay_plugin');
    // $activated = isset($option['cpt_manager']) ? $option['cpt_manager'] : false;
    // if (!$activated) return;
    if (!$this->managerActive('cpt_manager')) return;

    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();

    $this->setSubpages();
    $this->settings->addSubPages($this->subpages)->register();

    $this->storeCustomPostTypes();

    if (!empty($this->custom_post_types))
      add_action('init', array($this, 'registerCustomPostTypes'));
  }

  public function storeCustomPostTypes() {
    $this->custom_post_types = array(
      array(
        'post_type' => 'itay_product',
        'name' => 'Products',
        'singular_name' => 'Product',
        'public' => true,
        'has_archive' => true
      ),
      array(
        'post_type' => 'itay_comicbook',
        'name' => 'Comic Books',
        'singular_name' => 'Comic Book',
        'public' => true,
        'has_archive' => true
      ),

    );
  }

  public function registerCustomPostTypes() {
    foreach ($this->custom_post_types as $post_type) {
      register_post_type(
        $post_type['post_type'],
        array(
          'labels' => array(
            'name' => $post_type['name'],
            'singular_name' => $post_type['singular_name'],
          ),
          'public' => $post_type['public'],
          'has_archive' => $post_type['has_archive']
        )
      );
    }
  }
  public function setSubPages() {
    $this->subpages = array(
      [
        'parent_slug' => 'itay_plugin',
        'page_title' => 'Custom Post Types',
        'menu_title' => 'CPT Manager',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_cpt',
        'callback' => array($this->callbacks, 'cptManager'),
      ]
    );
  }
}
