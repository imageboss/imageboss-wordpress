<?php
function image_boss_settings() {

  if ($_GET['action'] == 'imageboss-warning-screen') {
    echo "<h3>Caution</h3>";
    $url = site_url();
    echo "<h4>Please check if the host " . $url . " is on the list of authorised hosts on the <a target='_blank' href='https://imageboss.me/dashboard'>ImageBoss Dashboard</a></h4>";
    echo "<p class='b-text'>Do you confirm that have a ImageBoss Account and it is properly configurated?<p>";
  ?>
    <form method="post" action="options.php" id="welcome_image_boss_settings">
      <?php settings_fields('imageboss-settings-group');?>
      <?php do_settings_sections('imageboss-settings-group');?>
      <table class="form-table">
          <tr valign="top"  style="display: none;">
          <td><input type="checkbox" id="ibup_auto_imageboss_cdn" name="ibup_auto_imageboss_cdn" value="yes" <?php if ($_POST['ibup_auto_imageboss_cdn'] == 'yes') {
              echo 'checked';
          }
          ?>/></td>
          </tr>
      </table>

      <input type="submit" id="aei-im" class="button-primary" value="Yes"> &nbsp;&nbsp;<a class='button-primary b-text' href="<?php echo admin_url('admin.php?page=imageboss-setting'); ?>"> No </a>
    </form>
    <?php if (isset($_GET['settings-updated'])) { ?>
          <script>
            window.location = "<?php echo admin_url('admin.php?page=imageboss-setting'); ?>";
          </script>
  <?php }
  } else {
    if (get_option('ibup_auto_imageboss_cdn') || $_POST['ibup_auto_imageboss_cdn'] == 'yes') {
  ?>
    <form method="post" action="<?php echo admin_url('admin.php?page=imageboss-setting&action=imageboss-warning-screen') ?>" id="image_boss_settings">
  <?php } else { ?>
  <form method="post" action="options.php" id="image_boss_settings">
  <?php }?>

  <div class="wrap">
  <h3>ImageBoss Settings</h3>
  <?php if (isset($_GET['settings-updated'])) {
    echo "<div class='updated'><p>You have successfully saved the settings.</p></div>";
    }
  ?>

  <?php settings_fields('imageboss-settings-group');?>
  <?php do_settings_sections('imageboss-settings-group');?>
    <table class="form-table">
      <tr valign="top">
      <td scope="row" style="width: 40%;">Automatically use ImageBoss CDN for all my images</td>
      <td>
        <input type="checkbox" id="ibup_auto_imageboss_cdn" name="ibup_auto_imageboss_cdn" value="yes" <?php if (get_option('ibup_auto_imageboss_cdn') != '') {
              echo 'checked';
          }
          ?> />
      </td>
      </tr>
    </table> <br />
    <input type="submit" class="button-primary" value="Save Changes">
    </form>

  </div> <br /> <br /> <br /> <br />
  <div>
    <h4>Useful Links</h4>
    <a class='button action' target='_blank' href='https://imageboss.me/users/sign_up'>Create Account</a>
    <a class='button action' target='_blank' href='https://imageboss.me/docs'>ImageBoss Docs</a>
    <a class='button action' target='_blank' href='https://github.com/imageboss/imageboss-wordpress'>Plugin Documentation</a>
    <a class='button action' target='_blank' href='https://imageboss.me/dashboard'>ImageBoss Dashboard</a>
  </div>
  <?php
  }
}
