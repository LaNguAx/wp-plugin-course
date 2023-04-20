<?php

/**
 * @package ItayPlugin
 */

namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\TestimonialCallbacks;


class TestimonialController extends BaseController {
  public $settings;
  public $callbacks;
  public $subpage = array();
  public $testimonial_updated = false;

  public function register() {
    if (!$this->managerActive('testimonial_manager')) return;

    $this->settings = new SettingsApi();
    $this->callbacks = new TestimonialCallbacks();


    add_action('init', array($this, 'testimonial_cpt'));
    add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
    add_action('save_post', array($this, 'save_meta_box'));
    add_action('manage_testimonial_posts_columns', array($this, 'set_custom_columns'));
    add_action('manage_testimonial_posts_custom_column', array($this, 'set_custom_columns_data'), 10, 2);
    add_filter('manage_edit-testimonial_sortable_columns', array($this, 'set_custom_columns_sortable'));

    $this->setShortcodePage();
    add_shortcode('testimonial-form', array($this, 'testimonial_form'));
  }
  public function testimonial_form() {
    // Here instead of writing html here we can create a new file and require it once here and output it in a clean way using ob_Start and ob_clean_End.
    // This'll tell php to read whatever we're gonna write but don't  print it directly in this page, wait for the code to tell you how to handle this page.
    // Whenever we need to print html that needs to contain php execution, it's best to use ob_start and ob_get_clean.
    ob_start();

    require_once("$this->plugin_path/templates/contact-form.php");
    // echo "<script src=\"$this->plugin_url/src/user/js/form.js\"";

    wp_enqueue_script('form-js', $this->plugin_url . '/build/form.js', array(), 1.0, true);
    wp_enqueue_style('form-style', $this->plugin_url . 'build/userstyle.css');

    return ob_get_clean();
  }
  public function setShortcodePage() {
    $subpage = array(
      array(
        'parent_slug' => 'edit.php?post_type=testimonial',
        'page_title' => 'Shortcodes',
        'menu_title' => 'Shortcodes',
        'capability' => 'manage_options',
        'menu_slug' => 'itay_testimonial_shortcode',
        'callback' => array($this->callbacks, 'shortcodePage')
      )
    );
    $this->settings->addSubPages($subpage)->register();
  }

  public function set_custom_columns_sortable($columns) {
    $columns['name'] = 'name';
    $columns['approved'] = 'approved';
    $columns['featured'] = 'featured';
    return $columns;
  }
  public function set_custom_columns_data($column, $post_id) {
    $data = get_post_meta($post_id, 'testimonial_options', true);

    // This is my code which is more programmatic however offers less output configuration.
    // if ($column == 'approved' || $column == 'featured') {
    //   $newColumn = isset($data[$column]) && $data[$column] == 1 ? 'Yes' : 'No';
    //   echo $newColumn;
    //   return;
    // }
    // $newColumn = isset($data[$column]) ? $data[$column] : '';
    // echo $newColumn;

    // Teachers code, more explicit and offers more configuration.
    $name = isset($data['name']) ? $data['name'] : '';
    $email = isset($data['email']) ? $data['email'] : '';
    $approved = isset($data['approved']) && $data['approved'] === 1 ? 'Yes' : 'No';
    $featured = isset($data['featured']) && $data['featured'] === 1 ? 'Yes' : 'No';

    switch ($column) {
      case 'name':
        echo '<strong>' . $name . '</strong><br><a href="mailto:' . $email . '">' . $email . '</a>';
        break;

      case 'approved':
        echo $approved;
        break;

      case 'featured':
        echo $featured;
        break;
    }
  }
  public function set_custom_columns($columns) {
    // $columns = array(
    //   'title' => 'This is the title',
    //   'date' => '1/1/2001'
    // );
    $title = $columns['title'];
    $date = $columns['date'];
    unset($columns['title'], $columns['date']);


    $columns['name'] = 'Author Name';
    $columns['title'] = $title;
    $columns['approved'] = 'Approved';
    $columns['featured'] = 'Featured';
    $columns['date'] = $date;



    return $columns;
  }

  public function testimonial_cpt() {
    $labels = array(
      'name' => 'Testimonials',
      'singular_name' => 'testimonial'
    );

    $args = array(
      'labels' => $labels,
      'public' => true,
      'has_archive' => false,
      'menu_icon' => 'dashicons-testimonial',
      'exclude_from_search' => true,
      'publicly_queryable' => false,
      'supports' => array('title', 'editor'),
    );

    register_post_type('testimonial', $args);
  }

  public function add_meta_boxes() {
    add_meta_box('testimonial_options', 'Testimonial Options', array($this, 'render_features_box'), 'testimonial', 'side', 'default');
  }
  public function render_features_box($post) {
    wp_nonce_field('itay_testimonial_options', 'itay_testimonial_options_nonce');
    $data = get_post_meta($post->ID, 'testimonial_options', true);
?>
    <label for="itay_testimonial_author">Testimonial Author</label>
    <input type="text" name="itay_testimonial_author" id="itay_testimonial_author" value="<?php echo esc_attr((isset($data['name']) ? $data['name']  : '')) ?>">

    <br>

    <label for="itay_testimonial_email">Testimonial Email</label>
    <input type="text" name="itay_testimonial_email" id="itay_testimonial_email" value="<?php echo esc_attr((isset($data['email']) ? $data['email']  : '')) ?>">

    <br>

    <label for="itay_testimonial_approved">Testimonial Approved</label>
    <input type="checkbox" name="itay_testimonial_approved" id="approved" value="1" <?php echo esc_attr((isset($data['approved'])  && $data['approved'] == 1  ? 'checked'  : '')) ?>>

    <br>

    <label for="itay_testimonial_featured">Testimonial Featured</label>
    <input type="checkbox" name="itay_testimonial_featured" id="featured" value="1" <?php echo esc_attr((isset($data['featured']) && $data['featured'] == 1 ? 'checked'  : '')) ?>>
<?php
  }
  public function save_meta_box($post_id) {
    if (!isset($_POST['itay_testimonial_options_nonce']))
      return $post_id;

    $nonce = $_POST['itay_testimonial_options_nonce'];
    if (!wp_verify_nonce($nonce, 'itay_testimonial_options')) {
      return $post_id;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $post_id;
    }

    if (!current_user_can('edit_post', $post_id)) {
      return $post_id;
    }


    $meta_inputs = array(
      'name' => sanitize_text_field($_POST['itay_testimonial_author']),
      'email' => sanitize_text_field($_POST['itay_testimonial_email']),
      'approved' => isset($_POST['itay_testimonial_approved']) ? 1 : 0,
      'featured' => isset($_POST['itay_testimonial_featured']) ? 1 : 0
    );
    update_post_meta($post_id, 'testimonial_options', $meta_inputs);
  }
}

/**
 * 
    // author email
    add_meta_box('testimonial_email', 'Email', array($this, 'render_email_box'), 'testimonial', 'side', 'default');

    // approved [checkbox]
    add_meta_box('testimonial_approved', 'Approved', array($this, 'render_approved_box'), 'testimonial', 'side', 'default');

    // featured [checkbox]
    add_meta_box('testimonial_featured', 'Featured', array($this, 'render_featured_box'), 'testimonial', 'side', 'default');
  }
  public function render_author_box($post) {
    wp_nonce_field('itay_testimonial_author', 'itay_testimonial_author_nonce');

    $value = get_post_meta($post->ID, '_itay_testimonial_author_key', true);
?>
    <label for="itay_testimonial_author">Testimonial Author</label>
    <input type="text" name="itay_testimonial_author" id="itay_testimonial_author" value="<?php echo esc_attr($value) ?>">
  <?php

  }

  public function render_email_box($post) {
    $value = get_post_meta($post->ID, '_itay_testimonial_email_key', true);
  ?>
    <label for="itay_testimonial_email">Testimonial Email</label>
    <input type="text" name="itay_testimonial_email" id="itay_testimonial_email" value="<?php echo esc_attr($value) ?>">
  <?php
  }
  public function render_approved_box($post) {
    $value = get_post_meta($post->ID, '_itay_testimonial_approved_key', true);
  ?>
    <label for="itay_testimonial_approved">Testimonial Approved</label>
    <input type="checkbox" name="itay_testimonial_approved" id="itay_testimonial_approved" value="1" <?php echo $value ? 'checked' : '' ?>>
  <?php

  }
  public function render_featured_box($post) {
    $value = get_post_meta($post->ID, '_itay_testimonial_featured_key', true);
  ?>
    <label for="itay_testimonial_featured">Testimonial Featured</label>
    <input type="checkbox" name="itay_testimonial_featured" id="itay_testimonial_featured" value="1" <?php echo $value ? 'checked' : '' ?>>
<?php

  }

  public function save_meta_box($post_id) {
    if (!isset($_POST['itay_testimonial_author_nonce']))
      return $post_id;

    $nonce = $_POST['itay_testimonial_author_nonce'];
    if (!wp_verify_nonce($nonce, 'itay_testimonial_author')) {
      return $post_id;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $post_id;
    }

    if (!current_user_can('edit_post', $post_id)) {
      return $post_id;
    }


    $meta_inputs = array(
      '_itay_testimonial_author_key' => sanitize_text_field($_POST['itay_testimonial_author']),
      '_itay_testimonial_email_key' => sanitize_text_field($_POST['itay_testimonial_email']),
      '_itay_testimonial_approved_key' => isset($_POST['itay_testimonial_approved']) ? $_POST['itay_testimonial_approved'] : null,
      '_itay_testimonial_featured_key' => isset($_POST['itay_testimonial_featured']) ? $_POST['itay_testimonial_featured'] : null
    );
    foreach ($meta_inputs as $key => $value) {
      update_post_meta($post_id, $key, $value);
    }
  }
 */
