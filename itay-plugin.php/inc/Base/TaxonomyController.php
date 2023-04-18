<?php

/**
 * @package ItayPlugin
 */

namespace Inc\Base;

use Inc\Api\SettingsApi;
use \Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\TaxonomyCallbacks;

class TaxonomyController extends BaseController {



  public $settings;
  public $callbacks;
  public $tax_callbacks;
  public $subpage = array();
  public $taxonomies = array();

  public function register() {
    if (!$this->managerActive('taxonomy_manager')) return;

    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();
    $this->tax_callbacks = new TaxonomyCallbacks();

    $this->setSubpage();

    $this->setSettings();
    $this->setSections();
    $this->setFields();


    $this->settings->addSubPages($this->subpage)->register();
    $this->storeCustomTaxonomies();
    if (!empty($this->taxonomies)) {
      add_action('init', array($this, 'registerCustomTaxonomy'));
    }
  }
  public function setSubpage() {
    $this->subpage = array(
      [
        'parent_slug' => 'itay_plugin',
        'page_title' => 'Taxonomy Manager',
        'menu_title' => 'Taxonomy Manager',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_taxonomy',
        'callback' => array($this->callbacks, 'taxonomyManager'),
      ]
    );
  }
  public function setSettings() {
    $args = array(
      'option_group' => 'itay_plugin_settings_tax',
      'option_name' => 'itay_plugin_tax',
      'callback' => array($this->tax_callbacks, 'taxSanitize')
    );
    $this->settings->setSettings($args);
  }
  public function setSections() {
    $args = array(array(
      'id' => 'itay_tax_index',
      'title' => 'Custom Taxonomy Manager',
      // this'll return the subtext for the page
      'callback' => array($this->tax_callbacks, 'taxSectionManager'),
      'page' => 'itay_taxonomy'
    ));
    $this->settings->setSections($args);
  }
  public function setFields() {
    $args = array(
      array(
        'id' => 'taxonomy',
        'title' => 'Custom Taxonomy ID',
        'callback' => array($this->tax_callbacks, 'textField'),
        'page' => 'itay_taxonomy',
        'section' => 'itay_tax_index',
        'args' => array(
          'option_name' => 'itay_plugin_tax',
          'label_for' => 'taxonomy',
          'placeholder' => 'e.g. genre',
        )
      ),
      array(
        'id' => 'singular_name',
        'title' => 'Singular Name',
        'callback' => array($this->tax_callbacks, 'textField'),
        'page' => 'itay_taxonomy',
        'section' => 'itay_tax_index',
        'args' => array(
          'option_name' => 'itay_plugin_tax',
          'label_for' => 'singular_name',
          'placeholder' => 'eg. genre',
          'array' => 'taxonomy'
        ),
      ),
      array(
        'id' => 'hierarchical',
        'title' => 'Hierarchical?',
        'callback' => array($this->tax_callbacks, 'checkboxField'),
        'page' => 'itay_taxonomy',
        'section' => 'itay_tax_index',
        'args' => array(
          'option_name' => 'itay_plugin_tax',
          'label_for' => 'hierarchical',
          'class' => 'ui-toggle',
          'array' => 'taxonomy'
        ),
      ),
      array(
        'id' => 'objects',
        'title' => 'Post Types',
        'callback' => array($this->tax_callbacks, 'checkboxPostTypesField'),
        'page' => 'itay_taxonomy',
        'section' => 'itay_tax_index',
        'args' => array(
          'option_name' => 'itay_plugin_tax',
          'label_for' => 'objects',
          'class' => 'ui-toggle',
          'array' => 'taxonomy'
        ),
      ),
    );
    $this->settings->setFields($args);
  }
  public function storeCustomTaxonomies() {
    //get the taxonomies array.
    $taxonomies = get_option('itay_plugin_tax') ?: array();
    // store that info into an array
    foreach ($taxonomies as $taxonomy) {
      $labels = array(
        'name'                       => $taxonomy['singular_name'],
        'singular_name'              => $taxonomy['singular_name'],
        'menu_name'                  => $taxonomy['singular_name'],
        'all_items'                  => __('All Items', 'text_domain'),
        'parent_item'                => __('Parent Item', 'text_domain'),
        'parent_item_colon'          => __('Parent Item:', 'text_domain'),
        'new_item_name'              => __('New Item Name', 'text_domain'),
        'add_new_item'               => __('Add New Item', 'text_domain'),
        'edit_item'                  => __('Edit Item', 'text_domain'),
        'update_item'                => __('Update Item', 'text_domain'),
        'view_item'                  => __('View Item', 'text_domain'),
        'separate_items_with_commas' => __('Separate items with commas', 'text_domain'),
        'add_or_remove_items'        => __('Add or remove items', 'text_domain'),
        'choose_from_most_used'      => __('Choose from the most used', 'text_domain'),
        'popular_items'              => __('Popular Items', 'text_domain'),
        'search_items'               => __('Search Items', 'text_domain'),
        'not_found'                  => __('Not Found', 'text_domain'),
        'no_terms'                   => __('No items', 'text_domain'),
        'items_list'                 => __('Items list', 'text_domain'),
        'items_list_navigation'      => __('Items list navigation', 'text_domain'),
      );
      $this->taxonomies[] = array(
        'labels'                     => $labels,
        'hierarchical'               => isset($taxonomy['hierarchical']), // Is the taxonomy hierarchical (have descendants) like categories or not hierarchical like tags
        'public'                     => true,  // Whether a taxonomy is intended for use publicly either via the admin interface or by front-end users.
        'show_ui'                    => true,  // Whether to generate and allow a UI for managing this taxonomy in the admin.
        'show_admin_column'          => true,  // Whether to allow automatic creation of taxonomy columns on associated post-types table.
        'show_in_nav_menus'          => true,  // Whether this taxonomy is available for selection in navigation menus.
        'show_tagcloud'              => true,  // Whether to allow the Tag Cloud widget to use this taxonomy.
        'rewrite' => array('slug' => $taxonomy['taxonomy']),
        'objects' =>  isset($taxonomy['objects']) ? $taxonomy['objects'] : null
      );
    }
    // register the taxonomy
  }
  public function registerCustomTaxonomy() {
    foreach ($this->taxonomies as $taxonomy) {
      $objects = isset($taxonomy['objects']) ? array_keys($taxonomy['objects']) : null;
      register_taxonomy($taxonomy['rewrite']['slug'], $objects, $taxonomy);
    }
  }
}
