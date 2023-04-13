<div class="wrap">
  <h1>AlecaddPlugin</h1>
  <?php settings_errors(); ?>

  <!-- We need to point to the options.php, this is the built in page that handles the all the updates save/delete for our custom fields. -->
  <form method="post" action="options.php">
    <?php
    settings_fields('itay_options_group');
    do_settings_sections('itay_plugin');
    submit_button();

    ?>
  </form>

</div>