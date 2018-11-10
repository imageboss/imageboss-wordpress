<?php
/*
Plugin Name: ImageBoss
Description: Content aware image resizing, cropping, compression, cache and CDN. All web development best practices, hassle free in one simple and powerful API.
Version: 1.0.9
Author: ImageBoss
Author URI: https://imageboss.me
License: MIT
License URI: https://opensource.org/licenses/MIT
*/

require_once plugin_dir_path(__FILE__) . '/includes/url.php';
require_once plugin_dir_path(__FILE__) . '/admin/imageboss-admin.php';
require_once plugin_dir_path(__FILE__) . '/public/imageboss-public.php';
require_once plugin_dir_path(__FILE__) . '/uninstall.php';

register_activation_hook(__FILE__, 'ibup_plugin_activate');
function ibup_plugin_activate()
{
    add_option('ibup_plugin_redirect', true);
}
