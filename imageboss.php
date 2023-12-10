<?php
/*
Plugin Name: ImageBoss
Description: Images Up To 60% Smaller & CDN.
Version: 5.0.1
Author: ImageBoss
Author URI: https://imageboss.me
License: MIT
License URI: https://opensource.org/licenses/MIT
*/

define('IBUP_API', 'https://img.imageboss.me');
define('IBUP_BASENAME', plugin_basename(__FILE__));

require plugin_dir_path(__FILE__) . '/includes/url.php';
require plugin_dir_path(__FILE__) . '/admin/imageboss-admin.php';
require plugin_dir_path(__FILE__) . '/public/imageboss-public.php';
require plugin_dir_path(__FILE__) . '/uninstall.php';
