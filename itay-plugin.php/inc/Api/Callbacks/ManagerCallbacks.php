<?php


/**
 * @package ItayPlugin
 */

namespace Inc\Api\Callbacks;

use \Inc\Base\BaseController;

class ManagerCallbacks extends BaseController {
  public function checkboxSanitize($input) {

    $output = array();
    // In this loop we need to check if the input inside itself has a key that is equal to $key.
    foreach ($this->managers as $key => $value) {
      $output[$key] = (isset($input[$key]) and $input[$key] == 1) ? true : false;
    }
    return $input;
  }
  public function adminSectionManager() {
    echo 'Manage the Sections and Features of this plugin by activating the checkboxes from the following list.';
  }
  public function checkboxField($args) {
    $name = $args['label_for'];
    $classes = $args['class'];
    $checkbox = get_option($args['option_name']);

    echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $args['option_name'] . '[' . $name . ']" value="1"' . (isset($checkbox[$name]) && $checkbox[$name] ? 'checked' : '') . '/><label for="' . $name . '"><div></div></label></div>';
  }
}
