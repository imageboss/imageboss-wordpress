<?php


add_action('admin_init', 'ibup_plugin_redirect');
function ibup_plugin_redirect()
{
  if (get_option('ibup_plugin_redirect', false)) {
    delete_option('ibup_plugin_redirect');
    exit(wp_redirect("admin.php?page=imageboss-setting"));
  }
}
