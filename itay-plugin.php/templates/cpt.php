<div class="wrap">
  <h1>AlecaddPlugin</h1>
  <?php settings_errors(); ?>




  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab-1">Your Custom Post Types</a></li>
    <li><a href="#tab-2">Add Custom Post Type</a></li>
    <li><a href="#tab-3">Export</a></li>
  </ul>

  <div class="tab-content">
    <div id="tab-1" class="tab-pane active">
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

            echo "<tr><td>{$options['post_type']}</td><td>{$options['singular_name']}</td><td>{$options['plural_name']}</td><td class='text-center'>{$public}</td><td class='text-center'>{$has_archive}</td><td class='actions-container text-center'><a href='#'>EDIT</a>";

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
    <div id="tab-2" class="tab-pane">
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
    </div>
  </div>


</div>