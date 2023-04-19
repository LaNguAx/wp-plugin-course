<?php


/**
 * 
 * @package itay_plugin
 * 
 */

namespace Inc\Base;

use Inc\Base\BaseController;

class MediaWidgetController extends BaseController {
  public $subpage = array();

  public function register() {
    if (!$this->managerActive('media_widget')) return;
  }
}
