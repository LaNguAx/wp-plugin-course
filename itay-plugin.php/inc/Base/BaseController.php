<?php

/**
 * @package ItayPlugin
 */

namespace Inc\Base;

class BaseController {
  public string $plugin_path;
  public string $plugin_url;
  public string $plugin_name;
  public array $managers = array();

  public function __construct() {
    // Specifiy the level of indentation of our file.
    $this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
    $this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
    $this->plugin_name = plugin_basename(dirname(__FILE__, 3)) . '/itay-plugin.php';

    $this->managers = array(
      'cpt_manager' => 'Activate CPT Manager',
      'taxonomy_manager' => 'Activate Taxonomy Manager',
      'media_widget' => 'Activate Media Widget',
      'gallery_manager' => 'Activate Gallery Manager',
      'testimonial_manager' => 'ActivateTestimonial Manager',
      'templates_manager' => 'Activate Templates Manager',
      'login_manager' => 'Activate Login Manager',
      'membership_manager' => 'Activate Membership Manager',
      'chat_manager' => 'Activate Chat Manager'
    );
  }
}
