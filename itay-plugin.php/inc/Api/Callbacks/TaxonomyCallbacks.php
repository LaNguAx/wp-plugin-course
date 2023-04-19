<?php


/**
 * @package ItayPlugin
 */

namespace Inc\Api\Callbacks;

use \Inc\Base\BaseController;

class TaxonomyCallbacks {
  public function taxSanitize($input) {

    $output = get_option('itay_plugin_tax');
    // Remove record from array
    if (isset($_POST['remove'])) {
      unset($output[$_POST['remove']]);

      return $output;
    }

    if (!$output) {
      $output  = array($input['taxonomy'] => $input);
      return $output;
    }
    $output[$input['taxonomy']] = $input;

    return $output;
  }
  public function taxSectionManager() {
    echo 'Create as many taxonomies as you want';
  }
  public function textField($args) {
    // return the input
    $name = $args['label_for'];
    $option_name = $args['option_name'];
    $value = '';
    if (isset($_POST['edit_taxonomy'])) {
      $input = get_option($option_name);
      $value = $input[$_POST['edit_taxonomy']][$name];
    }

    echo '<input type="text"  class="regular-text" name="' . $args['option_name'] . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '" required ' . ($name == 'post_type' && $value ? 'readonly' : '') . '>';
  }
  public function checkboxField($args) {
    $name = $args['label_for'];
    $classes = $args['class'];
    $checked = '';
    if (isset($_POST['edit_taxonomy'])) {
      $checkbox = get_option($args['option_name']);
      $checked = isset($checkbox[$_POST['edit_taxonomy']][$name]);
    }

    echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $args['option_name'] . '[' . $name . ']" value="1"' . ($checked ? 'checked' : '') . '/><label for="' . $name . '"><div></div></label></div>';
  }

  public function checkboxPostTypesField($args) {
    $output = '';
    $name = $args['label_for'];
    $classes = $args['class'];
    $checked = '';
    if (isset($_POST['edit_taxonomy'])) {
      $checkbox = get_option($args['option_name']);
    }

    $post_types = get_post_types(array('show_ui' => true));

    foreach ($post_types as $post) {
      if (isset($_POST['edit_taxonomy'])) {
        $checked = isset($checkbox[$_POST['edit_taxonomy']][$name][$post]);
      }
      $output .= '<div class="' . $classes . ' mb-10"><input type="checkbox" id="' . $post . '" name="' . $args['option_name'] . '[' . $name . '][' . $post . ']" value="1"' . ($checked ? 'checked' : '') . '/><label for="' . $post . '"><div></div></label><strong>' . $post . '</strong></div>';
    }

    echo $output;
  }
}
