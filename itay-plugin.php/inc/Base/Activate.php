<?php

/**
 * @package ItayPlugin
 */

namespace Inc\Base;

class Activate {
  public static function activate() {
    flush_rewrite_rules();
    $default = array();

    if (!get_option('itay_plugin')) {
      update_option('itay_plugin', $default);
    }

    if (!get_option('itay_plugin_cpt')) {
      update_option('itay_plugin_cpt', $default);
    }
  }
}
