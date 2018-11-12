<?php

register_uninstall_hook(IBUP_BASENAME, 'ibup_uninstall_plugin');

function ibup_uninstall_plugin() {
  $prefix = 'ibup_';
  $options = array('plugin_redirect', 'auto_imageboss_cdn');

  array_map(function($option) {
    delete_option($prefix . $option);
    delete_site_option($prefix . $option);
  }, $options);
}
