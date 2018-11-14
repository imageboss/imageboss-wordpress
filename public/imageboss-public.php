<?php

// wraps the entire blog html output
function ibup_buffer_callback($buffer) {
  return ibup_apply_imageboss_urls($buffer);
}

add_action('wp_head', 'ibup_buffer_start', 999);
function ibup_buffer_start() {
  ob_start("ibup_buffer_callback");
}

add_action('wp_footer', 'ibup_buffer_end', 999);
function ibup_buffer_end() {
  ob_end_flush();
}

add_filter('wp_get_attachment_url', 'ibup_replace_image_url', 100);
function ibup_replace_image_url($url){
  if (!is_admin() && IBUP_AUTO_CDN && preg_match('/\.(jpg|jpeg|gif|png|webp)$/i', $url)) {
      return ibup_apply_cdn($url);
  }

  return $url;
}
