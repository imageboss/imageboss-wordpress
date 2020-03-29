<?php

add_action('wp_head', 'ibup_buffer_start');
function ibup_buffer_start() {
  if (!wp_doing_ajax() && ibup_is_activated()) {
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
