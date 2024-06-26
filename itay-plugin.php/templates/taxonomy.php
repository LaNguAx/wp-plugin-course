<div class="wrap">
  <h1>Taxonomy Manager</h1>
  <?php settings_errors(); ?>




  <ul class="nav nav-tabs">
    <li class="<?php echo (!isset($_POST['edit_taxonomy'])) ? 'active' : '' ?>"><a href="#tab-1">Your Taxonomies</a></li>
    <li class="<?php echo (isset($_POST['edit_taxonomy'])) ? 'active' : '' ?>"><a href="#tab-2"><?php echo (isset($_POST['edit_taxonomy'])) ? 'Edit' : 'Add' ?> Taxonomy</a></li>
    <li><a href="#tab-3">Export</a></li>
  </ul>

  <div class="tab-content">
    <div id="tab-1" class="tab-pane <?php echo (!isset($_POST['edit_taxonomy'])) ? 'active' : '' ?>">
      <h3>Manage your custom Taxonomies</h3>
      <?php
      $optionss = get_option('itay_plugin_tax');
      if ($optionss) {

      ?>
        <table class="cpt-table">
          <tr>
            <th>ID</th>
            <th>Singular Name</th>
            <th class="text-center">Hierarchical</th>
            <th class="text-center">Actions</th>
          </tr>
          <?php
          foreach ($optionss as $options) {

            $hierarchical = isset($options['hierarchical']) ? 'Yes' : 'No';

            echo "<tr><td>{$options['taxonomy']}</td><td>{$options['singular_name']}</td><td class='text-center'>{$hierarchical}</td><td class='actions-container text-center'>";

            echo '<form method="post" action="" class="inline-block">';
            echo '<input type="hidden" name="edit_taxonomy" value="' . $options['taxonomy'] . '">';
            submit_button('Edit', 'primary small', 'submit', false);
            echo '</form> ';


            echo '<form method="post" action="options.php" class="inline-block">';
            settings_fields('itay_plugin_settings_tax');
            echo '<input type="hidden" name="remove" value="' . $options['taxonomy'] . '">';
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
      <?php  }
      ?>
    </div>
    <div id="tab-2" class="tab-pane <?php echo (isset($_POST['edit_taxonomy'])) ? 'active' : '' ?>">
      <!-- We need to point to the options.php, this is the built in page that handles the all the updates save/delete for our custom fields. -->
      <form method="post" action="options.php">
        <?php
        settings_fields('itay_plugin_settings_tax');
        do_settings_sections('itay_taxonomy');
        submit_button();
        ?>
      </form>
    </div>
    <div id="tab-3" class="tab-pane">
      <h3>Export Your Custom Taxonomies</h3>
    </div>
  </div>


</div>