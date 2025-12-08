<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('wp_head', 'ibup_buffer_start');
add_action('wp_footer', 'ibup_buffer_end', PHP_INT_MAX);

function ibup_buffer_start() {
  if (!wp_doing_ajax() && ibup_is_activated()) {
    ob_start();
  }
}

function ibup_buffer_end() {
  if (!wp_doing_ajax() && ibup_is_activated() && ob_get_level() > 0) {
    $buffer = ob_get_clean();
    echo ibup_apply_imageboss_urls($buffer);
  }
}
