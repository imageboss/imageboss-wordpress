<?php
/*
Plugin Name: ImageBoss
Description: Content aware image resizing, cropping, compression, cache and CDN. All web development best practices, hassle free in one simple and powerful API.
Version: 1.0.18
Author: ImageBoss
Author URI: https://imageboss.me
License: MIT
License URI: https://opensource.org/licenses/MIT
*/

define('IBUP_BASENAME', plugin_basename(__FILE__));

require plugin_dir_path(__FILE__) . '/includes/url.php';
require plugin_dir_path(__FILE__) . '/admin/imageboss-admin.php';
require plugin_dir_path(__FILE__) . '/public/imageboss-public.php';
require plugin_dir_path(__FILE__) . '/uninstall.php';
