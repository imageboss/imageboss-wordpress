<?php
/*
Plugin Name: ImageBoss
Description: Image Optimization & CDN - Optimize your images with compression and CDN delivery.
Version: 5.0.2
Author: ImageBoss
Author URI: https://imageboss.me
License: MIT
License URI: https://opensource.org/licenses/MIT
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define('IBUP_API', 'https://img.imageboss.me');
define('IBUP_BASENAME', plugin_basename(__FILE__));

require plugin_dir_path(__FILE__) . '/includes/url.php';
require plugin_dir_path(__FILE__) . '/admin/imageboss-admin.php';
require plugin_dir_path(__FILE__) . '/public/imageboss-public.php';
