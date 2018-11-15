<?php

register_activation_hook(IBUP_BASENAME, 'ibup_plugin_activate');
function ibup_plugin_activate() {
  add_option('ibup_plugin_redirect', true);
}

add_action('admin_init', 'ibup_plugin_redirect');
function ibup_plugin_redirect()
{
  if (get_option('ibup_plugin_redirect', false)) {
    delete_option('ibup_plugin_redirect');
    exit(wp_redirect("admin.php?page=imageboss"));
  }
}
