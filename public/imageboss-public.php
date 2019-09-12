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

add_filter('image_downsize', 'ibup_image_downsize', 10, 3);
function ibup_image_downsize($return, $attachment_id, $size) {

  if (IBUP_AUTO_THUMBNAILS && $attachment_id) {
    $img_url = wp_get_attachment_url($attachment_id);
    $available_sizes = ibup_get_all_defined_sizes();

    $params = [];
    if (is_array($size)) {
      $width = isset($size[0]) ? $size[0] : null;
      $height = isset($size[1]) ? $size[1] : null;
    } else if (isset($available_sizes[$size])) {
      $size = $available_sizes[$size];
      $width = $size['width'];
      $height = $size['height'];
    }

    if ($width && $height) {
      $operation = 'cover';
      $cover_mode = 'smart';
    } else if ($width) {
      $operation = 'width';
    } else if ($height) {
      $operation = 'height';
    }

    $img_url = ibup_mount_imageboss_url($img_url, $operation, $cover_mode, $width, $height);

    if (!$width || !$height) {
      $meta = wp_get_attachment_metadata($attachment_id);

      $meta['width'] = isset($meta['width']) ? $meta['width'] : null;
      $meta['height'] = isset($meta['height']) ? $meta['height'] : null;
      $width = isset($width) ? $width : $meta['width'];
      $height = isset($height) ? $height : $meta['height'];
    }

    $return = [$img_url, $width, $height, true];
  }

  return $return;
}


function ibup_get_all_defined_sizes() {
  $theme_image_sizes = wp_get_additional_image_sizes();
  $sizes = [];
  foreach (get_intermediate_image_sizes() as $s) {
    $sizes[$s] = array('width' => '', 'height' => '', 'crop' => false);
    if (isset($theme_image_sizes[$s])) {
      $sizes[$s]['width'] = intval($theme_image_sizes[$s]['width']);
      $sizes[$s]['height'] = intval($theme_image_sizes[$s]['height']);
      $sizes[$s]['crop'] = $theme_image_sizes[$s]['crop'];
    } else {
      // For default sizes set in options
      $sizes[ $s ]['width']  = get_option( "{$s}_size_w" );
      $sizes[ $s ]['height'] = get_option( "{$s}_size_h" );
      $sizes[ $s ]['crop']   = get_option( "{$s}_crop" );
    }
  }

  return $sizes;
}

add_filter('wp_calculate_image_srcset', 'ibup_calculate_image_srcset', 10, 5);
function ibup_calculate_image_srcset($sources, $size_array, $image_src, $image_meta, $attachment_id) {
    if (IBUP_AUTO_THUMBNAILS) {
        foreach ($sources as $i => $image_size) {
            if ($image_size['descriptor'] === 'w') {
                if ($attachment_id) {
                    $image_src = wp_get_attachment_url($attachment_id);
                }

                // $sources[$i]['url'] = ibup_mount_imageboss_url($img_url, 'cover', 'smart', $width, $height);
                $sources[$i]['url'] = json_encode($image_size);
            }
        }
    }

    return $sources;
}
