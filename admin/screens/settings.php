<?php
function image_boss_settings() {
?>

<form method="post" action="options.php" id="image_boss_settings">
  <div class="wrap">
    <h2>ImageBoss</h2>

    <div class="notice">
      <h4>Caution</h4>
      <p>
        In order to identify your traffic you need to add the host of your images on your <a target='_blank' href='https://imageboss.me/dashboard'>ImageBoss Dashboard</a>.
        It usually is: <strong><?= site_url(); ?></strong>.
      </p>
    </div>

    <?php if (isset($_GET['settings-updated'])) { ?>
      <div class='updated'><p>You have successfully saved the settings.</p></div>
    <?php } ?>

    <br />
    <strong>Options</strong>

    <?php settings_fields('imageboss-settings-group'); ?>

    <table class="form-table">
      <tr>
        <td style="width: 20px;">
          <input
            type="checkbox"
            id="ibup_auto_imageboss_cdn"
            name="ibup_auto_imageboss_cdn"
            value="yes"
            <?php echo get_option('ibup_auto_imageboss_cdn') ? 'checked' : '' ?>
          />
        </td>
        <td><label for="ibup_auto_imageboss_cdn">Automatically use ImageBoss' CDN for all my images.</label></td>
      </tr>
      <tr>
        <td style="width: 20px;">
          <input
            type="checkbox"
            id="ibup_auto_imageboss_thumbnails"
            name="ibup_auto_imageboss_thumbnails"
            value="yes"
            <?php echo get_option('ibup_auto_imageboss_thumbnails') ? 'checked' : '' ?>
          />
        </td>
        <td><label for="ibup_auto_imageboss_thumbnails">Use ImageBoss to generate thumbnails.</label></td>
      </tr>
    </table>
    <br />

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
