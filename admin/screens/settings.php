<?php
function image_boss_settings() {
?>

<form method="post" action="options.php" id="image_boss_settings">
  <div class="wrap">
    <h2>ImageBoss</h2>

    <?php if (isset($_GET['settings-updated'])) { ?>
      <div class='updated'><p>You have successfully saved the settings.</p></div>
    <?php } ?>

    <h3>Step 1: Account</h3>
    <p>Create your <a href="https://imageboss.me/" target="_blank">ImageBoss Account</a>.</p>

    <h3>Step 2: Image Source</h3>
    <p>
      Connect ImageBoss to your images on <a target='_blank' href='https://imageboss.me/dashboard'>ImageBoss Dashboard</a> by adding your image source.
    </p>
    <?php settings_fields('imageboss-settings-group'); ?>

    <h3>Step 3: Source Name</h3>
    <p>This is the name you gave to your Image Source on Step 2.</p>
    <input
        id="ibup_imageboss_source"
        name="ibup_imageboss_source"
        placeholder="mywordpress-images"
        style="width: 300px"
        value="<?php echo filter_var(get_option('ibup_imageboss_source'), FILTER_SANITIZE_STRING) ?>"
    /> <br />
    <h3>Activate</h3>
    <input
      type="checkbox"
      id="ibup_imageboss_active"
      name="ibup_imageboss_active"
      value="true"
      <?php echo get_option('ibup_imageboss_active') ? 'checked' : '' ?>
    /> <label for="ibup_imageboss_active">If you have all set, check this box to activate ImageBoss on your images.</label>
    <br /><br />
    <h3>Advanced Configurations</h3>
    <h3>Lazyload Images</h3>
    <input
      type="checkbox"
      id="ibup_imageboss_lazyload_active"
      name="ibup_imageboss_lazyload_active"

      value="true"
      <?php echo get_option('ibup_imageboss_lazyload_active') ? 'checked' : '' ?>
    /> <label for="ibup_imageboss_lazyload_active">If you want your images to be lazyloaded.</label>
    <br /><br />
    <h3>Whitelist Images</h3>
    <p>By default ImageBoss will wrap all your images. If you don't want this to happen you can add bellow the hosts (and/or path) you want ImageBoss to intercept:</p>
      <textarea
        id="ibup_imageboss_hosts"
        name="ibup_imageboss_hosts"
        rows="4" cols="80"
      ><?php echo filter_var(get_option('ibup_imageboss_hosts'), FILTER_SANITIZE_STRING) ?></textarea> <br /> <br />
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
