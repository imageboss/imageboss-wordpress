<?php

register_uninstall_hook(__FILE__, 'ibup_uninstall_plugin');

function ibup_uninstall_plugin() {
  $prefix = 'ibup_';
  $options = ['plugin_redirect', 'auto_imageboss_cdn'];

  array_map(function($option) {
    delete_option($prefix . $option);
    delete_site_option($prefix . $option);
  }, $options);
}
