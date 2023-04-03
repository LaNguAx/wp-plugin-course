<?php

/**
 * @package ItayPlugin
 */

class ItayPluginActivate {
  public static function activate() {
    flush_rewrite_rules();
  }
}
