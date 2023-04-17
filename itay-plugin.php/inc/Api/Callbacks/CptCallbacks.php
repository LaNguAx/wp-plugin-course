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

    if (!$output) {
      $output  = array($input['post_type'] => $input);
      return $output;
    }
    // print('<pre>' . print_r($output, true) . '</pre>');
    // print('<pre>' . print_r($input, true) . '</pre>');
    // die();
    // foreach ($output as $key => $value) {
    // Edit a CPT.
    // if ($input['post_type'] == $type) {
    //   $output[$type] = $input;
    // }
    // if ($input['post_type'] == $key) {
    //   $output[$input['post_type']] = $input;
    // }
    // print('<pre>' . print_r($key, true) . '</pre>');
    // print('<pre>' . print_r($input['post_type'] !== $key, true) . '</pre>');
    // die();
    // if (isset($output[$input['post_type']])) {
    $output[$input['post_type']] = $input;
    // } else {
    // $output[$input['post_type']] = $input;
    // }

    return $output;
  }

  public function cptSectionManager() {
    echo 'Create as many Custom Post Types as you want';
  }

  public function textField($args) {
    // return the input
    $name = $args['label_for'];
    $option_name = $args['option_name'];
    $value = '';
    if (isset($_POST['edit_post'])) {
      $input = get_option($option_name);
      $value = $input[$_POST['edit_post']][$name];
    }

    echo '<input type="text"  class="regular-text" name="' . $args['option_name'] . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '" required ' . ($name == 'post_type' && $value ? 'readonly' : '') . '>';
  }


  public function checkboxField($args) {
    $name = $args['label_for'];
    $classes = $args['class'];
    $checked = '';
    if (isset($_POST['edit_post'])) {
      $checkbox = get_option($args['option_name']);
      $checked = isset($checkbox[$_POST['edit_post']][$name]);
    }

    echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $args['option_name'] . '[' . $name . ']" value="1"' . ($checked ? 'checked' : '') . '/><label for="' . $name . '"><div></div></label></div>';
  }
}
