<?php

/**
 * @package ItayPlugin
 */

namespace Inc\Base;

class Activate {
  public static function activate() {
    flush_rewrite_rules();
    if (get_option('itay_plugin')) return;

    $default = array();
    update_option('itay_plugin', $default);
  }
}
