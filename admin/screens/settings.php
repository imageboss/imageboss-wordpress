<?php
function image_boss_settings()
{

if ($_GET['action'] == 'imageboss-welcome-screen') {
  echo "<h3>Welcome to ImageBoss</h3>";
  $url = site_url();
  echo "<h3>Please check the host " . $url . " is on the list of authorised hosts on the <a target='_blank' href='https://imageboss.me/dashboard'>ImageBoss Dashboard</a></h3>";
  echo "<p class='b-text'>You have a ImageBoss Account?<p>";
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
  if (get_option('ibup_auto_imageboss_cdn') == '') {
?>
  <form method="post" action="<?php echo admin_url('admin.php?page=imageboss-setting&action=imageboss-welcome-screen') ?>" id="image_boss_settings">
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
    <th scope="row" style="width: 40%;">Automatically use ImageBoss CDN for all my images</th>
    <td>
      <input type="checkbox" id="ibup_auto_imageboss_cdn" name="ibup_auto_imageboss_cdn" value="yes" <?php if (get_option('ibup_auto_imageboss_cdn') != '') {
            echo 'checked';
        }
        ?> />
    </td>
    </tr>
  </table>

  <input type="submit" class="button-primary" value="Save Changes">
  </form>
</div>
<?php
}
}
