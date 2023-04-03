<?php

/**
 * @package ItayPlugin
 */

class ItayPluginDeactivate {
  public static function deactivate() {
    flush_rewrite_rules();
  }
}
