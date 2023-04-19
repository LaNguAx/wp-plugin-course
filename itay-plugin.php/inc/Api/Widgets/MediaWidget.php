<?php


/**
 * 
 * @package itay_plugin
 * 
 */

use WP_Widget;

class MediaWidget extends WP_Widget {
  // All of these variables are default variables that WP uses in the Widget API.
  public $widget_ID;

  public $widget_name;

  public $widget_options = array();

  public $control_options = array();

  public function __construct() {
    $this->widget_ID = 'itay_media_widget';
    $this->widget_name = 'Itay Media Widget';
    $this->widget_options = array(
      'classname' => $this->widget_ID,
      'description' => $this->widget_name,
      'customize_selective_refresh' => true
    );
    $this->control_options = array(
      'width' => 400,
      'height' => 350,
    );
  }
  public function register() {
    parent::__construct($this->widget_ID, $this->widget_name, $this->widget_options, $this->control_options);

    add_action('widgets_init', array($this, 'widgetsInit'));
  }
  public function widgetsInit() {
    register_widget($this);
  }

  // widget() -- takes care of generating the output in the front-end of the user

  public function widget($args, $instance) {
  }

  // from() -- takes care of generating the widget in the administration area

  public function form($instance) {
    $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Custom Text', 'itay_plugin');
    $title_id = esc_attr($this->get_field_id('title'))
?>
    <p>
      <label for="<?php echo $title_id ?>">Title</label>
    </p>
    <input type="text" class="widefat" name="<?php esc_attr($this->get_field_name('title')) ?>" id="<?php echo $title_id ?>" value="<?php $title ?>">


<?php
  }
  // update() -- takes care of updating the information of that specific widget.
}
