<?php

// Disable lazy loading for wp rocket
add_filter('do_rocket_lazyload', '__return_false');

// Disable lazy loading for jetpack
add_filter('lazyload_is_enabled', '__return_false');

// Disable srcset from wp
// While the library does not fully support srcset
add_filter('wp_calculate_image_srcset', '__return_false');

add_action('wp_head', 'ibup_buffer_start');
function ibup_buffer_start() {
  if (!wp_doing_ajax()) {
    ob_start("ibup_buffer_callback");
  }
}

// wraps the entire blog html output
function ibup_buffer_callback($buffer, $phase) {
  if ($phase & PHP_OUTPUT_HANDLER_FINAL || $phase & PHP_OUTPUT_HANDLER_END) {
    return ibup_apply_imageboss_urls($buffer);
  }

  return $buffer;
}