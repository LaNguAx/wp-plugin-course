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
}
