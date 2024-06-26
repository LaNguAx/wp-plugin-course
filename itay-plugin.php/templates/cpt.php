<div class="wrap">
  <h1>CPT Manager</h1>
  <?php settings_errors(); ?>




  <ul class="nav nav-tabs">
    <li class="<?php echo (!isset($_POST['edit_post'])) ? 'active' : '' ?>"><a href="#tab-1">Your Custom Post Types</a></li>
    <li class="<?php echo (isset($_POST['edit_post'])) ? 'active' : '' ?>"><a href="#tab-2"><?php echo (isset($_POST['edit_post'])) ? 'Edit' : 'Add' ?> Custom Post Type</a></li>
    <li><a href="#tab-3">Export</a></li>
  </ul>

  <div class="tab-content">
    <div id="tab-1" class="tab-pane <?php echo (!isset($_POST['edit_post'])) ? 'active' : '' ?>">
      <h3>Manage your custom post types</h3>
      <?php
      $optionss = get_option('itay_plugin_cpt');
      if ($optionss) {
      ?>
        <table class="cpt-table">
          <tr>
            <th>ID</th>
            <th>Singular Name</th>
            <th>Plural Name</th>
            <th class="text-center">Public</th>
            <th class="text-center">Archive</th>
            <th class="text-center">Actions</th>
          </tr>
          <?php
          foreach ($optionss as $options) {

            $public = isset($options['public']) ? 'Yes' : 'No';
            $has_archive = isset($options['has_archive']) ? 'Yes' : 'No';

            echo "<tr><td>{$options['post_type']}</td><td>{$options['singular_name']}</td><td>{$options['plural_name']}</td><td class='text-center'>{$public}</td><td class='text-center'>{$has_archive}</td><td class='actions-container text-center'>";

            echo '<form method="post" action="" class="inline-block">';
            echo '<input type="hidden" name="edit_post" value="' . $options['post_type'] . '">';
            submit_button('Edit', 'primary small', 'submit', false);
            echo '</form> ';


            echo '<form method="post" action="options.php" class="inline-block">';
            settings_fields('itay_plugin_settings_cpt');
            echo '<input type="hidden" name="remove" value="' . $options['post_type'] . '">';
            submit_button('Delete', 'delete small', 'submit', false, array(
              'onclick' => 'return confirm("Are you sure you want to delete this Custom Post Type? The data associated with it will not be deleted.");'
            ));

            echo '</form></td></tr>';
          }
          ?>
          <tr>

          </tr>
        </table>
      <?php   } else {
      ?>
        <h2>You currently have no post types registered.</h2>
      <?php } ?>
    </div>
    <div id="tab-2" class="tab-pane <?php echo (isset($_POST['edit_post'])) ? 'active' : '' ?>">
      <!-- We need to point to the options.php, this is the built in page that handles the all the updates save/delete for our custom fields. -->
      <form method="post" action="options.php">
        <?php
        settings_fields('itay_plugin_settings_cpt');
        do_settings_sections('itay_cpt');
        submit_button();
        ?>
      </form>
    </div>
    <div id="tab-3" class="tab-pane">
      <h3>Export Your Custom Post Types</h3>
      <?php foreach ($optionss as $option) { ?>
        <?php echo $option['singular_name'] ?>
        <pre class="prettyprint">
      // Register Custom Post Type
function custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Post Types', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Post Type', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Post Types', 'text_domain' ),
		'name_admin_bar'        => __( 'Post Type', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Post Type', 'text_domain' ),
		'description'           => __( 'Post Type Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => false,
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'post_type', $args );

}
add_action( 'init', 'custom_post_type', 0 );
</pre>

      <?php } ?>

    </div>
  </div>


</div>