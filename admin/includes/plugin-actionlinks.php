<?php

add_filter('plugin_action_links', 'ibup_plugin_admin_action_links', 10, 2);

function ibup_plugin_admin_action_links($links, $file) {
  if ($file === IBUP_BASENAME) {
    $settings_link = '<a href="admin.php?page=imageboss">Settings</a>';
    array_unshift($links, $settings_link);
  }
  return $links;
}
