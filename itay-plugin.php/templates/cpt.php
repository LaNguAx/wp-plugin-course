<div class="wrap">
  <h1>Itay Plugin</h1>
  <?php settings_errors(); ?>
  <form method="post" action="options.php">
    <?php
    settings_fields('itay_plugin_cpt_settings');
    do_settings_sections('itay_cpt');
    submit_button();
    ?>
  </form>

</div>