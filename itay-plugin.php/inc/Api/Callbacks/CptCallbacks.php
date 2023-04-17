<?php


/**
 * @package ItayPlugin
 */

namespace Inc\Api\Callbacks;

use \Inc\Base\BaseController;

class CptCallbacks {
  public function cptSanitize($input) {

    $output = get_option('itay_plugin_cpt');

    // Remove record from array
    if (isset($_POST['remove'])) {
      unset($output[$_POST['remove']]);

      return $output;
    }
    // var_dump($_POST);
    // die();


    if (!$output || count($output) == 0) {
      $output[$input['post_type']] = $input;
      return $output;
    }

    foreach ($output as $type) {
      if ($input['post_type'] !== $type) {
        $output[$input['post_type']] = $input;
      }
    }

    return $output;
  }

  public function cptSectionManager() {
    echo 'Create as many Custom Post Types as you want';
  }

  public function textField($args) {
    // return the input
    $name = $args['label_for'];
    $option_name = $args['option_name'];
    $input = get_option($option_name);
    // $value = $input[$name];

    echo '<input type="text" class="regular-text" name="' . $args['option_name'] . '[' . $name . ']" value="" placeholder="' . $args['placeholder'] . '" required>';
  }


  public function checkboxField($args) {
    $name = $args['label_for'];
    $classes = $args['class'];
    $checkbox = get_option($args['option_name']);

    echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $args['option_name'] . '[' . $name . ']" value="1"/><label for="' . $name . '"><div></div></label></div>';
  }
}
