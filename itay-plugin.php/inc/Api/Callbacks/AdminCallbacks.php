<?php


/**
 * @package ItayPlugin
 */

namespace Inc\Api\Callbacks;

use \Inc\Base\BaseController;

class AdminCallbacks extends BaseController {
  public function adminDashboard() {
    return require_once("$this->plugin_path/templates/admin.php");
  }
  public function cptManager() {
    return require_once("$this->plugin_path/templates/cpt.php");
  }
  public function taxonomyManager() {
    return require_once("$this->plugin_path/templates/taxonomy.php");
  }
  public function widgetsManager() {
    return require_once("$this->plugin_path/templates/widgets.php");
  }
  public function galleryManager() {
    return require_once("$this->plugin_path/templates/gallery.php");
  }
  public function testimonialManager() {
    return require_once("$this->plugin_path/templates/testimonial.php");
  }
  public function templatesManager() {
    return require_once("$this->plugin_path/templates/template.php");
  }
  public function loginManager() {
    return require_once("$this->plugin_path/templates/login.php");
  }
  public function membershipManager() {
    return require_once("$this->plugin_path/templates/membership.php");
  }
  public function chatManager() {
    return require_once("$this->plugin_path/templates/chat.php");
  }

  public function itayOptionsGroup($input) {
    // This callback is a filter function for the input passed by the Settings, create validation for input.
    return $input;
  }
  public function itayAdminSection() {
    echo 'Check this beautiful section!';
  }

  public function itayTextExample() {
    $value = esc_attr(get_option('text_example'));
    echo '<input type="text" class="regular-text" name="text_example" value="' . $value . '" placeeholder="Write Something Here!" />';
  }
}
