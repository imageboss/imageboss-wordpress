<?php
function image_boss_settings() {
?>

<form method="post" action="options.php" id="image_boss_settings">
  <div class="wrap">
    <h2>ImageBoss</h2>

    <?php if (isset($_GET['settings-updated'])) { ?>
      <div class='updated'><p>You have successfully saved the settings.</p></div>
    <?php } ?>

    <h3>Step 1</h3>
    <p>Create your <a href="https://imageboss.me/" target="_blank">ImageBoss Account</a>.</p>

    <h3>Step 2</h3>
    <p>
      In order to identify your traffic you need to add the host of the images you want to optimize on <a target='_blank' href='https://imageboss.me/dashboard'>ImageBoss Dashboard</a>.
    </p>

    <h3>Step 3</h3>
    <p>Comma separated list of your image hosts you want to connect with this plugin</p>
    <?php settings_fields('imageboss-settings-group'); ?>
      <textarea
        id="ibup_imageboss_hosts"
        name="ibup_imageboss_hosts"
        rows="4" cols="80"
      ><?php echo get_option('ibup_imageboss_hosts') ?></textarea> <br /> <br />
    <input type="submit" class="button-primary" value="Save Changes" />
  </form>

  </div> <br /> <br /> <br /> <br />
  <div>
    <h3>Useful Links</h3>
    <a class='button action' target='_blank' href='https://imageboss.me/pricing'>Create Account</a>
    <a class='button action' target='_blank' href='https://imageboss.me/dashboard'>ImageBoss Dashboard</a>
    <a class='button action' target='_blank' href='https://imageboss.me/docs'>ImageBoss Docs</a>
    <a class='button action' target='_blank' href='https://github.com/imageboss/imageboss-wordpress'>Plugin Documentation</a>
    <a class='button action' target='_blank' href='https://github.com/imageboss/imageboss-wordpress/issues'>Report a Bug</a>
  </div>
<?php
}
