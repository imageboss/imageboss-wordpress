<?php
/*
Plugin Name: ImageBoss
Description: Content aware image resizing, cropping, compression, cache and CDN. All web development best practices, hassle free in one simple and powerful API.
Version: 1.0.24
Author: ImageBoss
Author URI: https://imageboss.me
License: MIT
License URI: https://opensource.org/licenses/MIT
*/

define('IBUP_API', 'https://img.imageboss.me');
define('IBUP_BASENAME', plugin_basename(__FILE__));
define('IBUP_AUTO_CDN', get_option('ibup_auto_imageboss_cdn'));

require plugin_dir_path(__FILE__) . '/includes/url.php';
require plugin_dir_path(__FILE__) . '/admin/imageboss-admin.php';
require plugin_dir_path(__FILE__) . '/public/imageboss-public.php';
require plugin_dir_path(__FILE__) . '/uninstall.php';
