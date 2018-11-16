<?php

function ibup_get_original_url($url) {
  $url_sections = preg_split('/(https?:\/\/)/', $url, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
  $url_sections = array_chunk($url_sections, 2);

  return join(end($url_sections), '');
}

function ibup_is_imageboss_url($url) {
    return preg_match('/imageboss.me/', $url);
}

function ibup_mount_imageboss_url($src, $operation, $cover_mode, $width, $height, $options) {

  // do nothing if the user has the option disabled
  if (!$operation && !IBUP_AUTO_CDN) {
    return $src;
  }

  $template = '/:operation/:options/';

  if ($operation == 'cover') {
    $template = '/:operation::cover_mode/:widthx:height/:options/';
  } else if ($operation == 'width') {
    $template = '/:operation/:width/:options/';
  } else if ($operation == 'height') {
    $template = '/:operation/:height/:options/';
  }

  $src = ibup_get_original_url($src);
  $finalUrl = str_replace(':operation', $operation ?: 'cdn', $template);
  $finalUrl = str_replace(':cover_mode', $cover_mode, $finalUrl);
  $finalUrl = str_replace(':width', $width, $finalUrl);
  $finalUrl = str_replace(':height', $height, $finalUrl);
  $finalUrl = str_replace(':options', $options, $finalUrl);
  $finalUrl = preg_replace('/\/\//', '/', $finalUrl);
  $finalUrl = preg_replace('/:\//', '/', $finalUrl);

  return IBUP_API . $finalUrl . $src;
}

function ibup_apply_cdn($size) {
  return IBUP_API . '/cdn/' . ibup_get_original_url(trim($size));
}

function ibup_add_option($options, $option) {
  $options = array_filter(explode(',', $options));
  array_push($options, $option);
  return implode(',', $options);
}

function ibup_apply_imageboss_urls($the_content) {
  $all_images_pattern = '#<img.*?\\/?>#';
  return preg_replace_callback($all_images_pattern, function($matches) {
    return ibup_process_image_fragment($matches[0]);
  }, $the_content);
}

function ibup_process_image_fragment($the_content) {
  $img = simplexml_load_string($the_content);
  $src = $img['src'];

  if (preg_match('/gravatar/', $src) && !preg_match('/^http/', $src)) {
    return $the_content;
  }

  $srcset     = $img['srcset'];
  $operation  = $img['imageboss-operation'];
  $cover_mode = $img['imageboss-cover-mode'];
  $width      = $img['imageboss-width'];
  $height     = $img['imageboss-height'];
  $options    = $img['imageboss-options'];

  $new_src = ibup_mount_imageboss_url($src, $operation, $cover_mode, $width, $height, $options);

  $img['src'] = $new_src;

  if ($srcset && !$operation && IBUP_AUTO_CDN) {
    $sizes = explode(',', $srcset);
    $sizes = array_map('ibup_apply_cdn', $sizes);
    $new_srcset = implode(',', $sizes);
    $img['srcset'] = $new_srcset;

  // add support for retina displays
  } else if ($operation) {
    $new_src_2x = ibup_mount_imageboss_url($src, $operation, $cover_mode, $width, $height, ibup_add_option($options, 'dpr:2'));
    $new_src_3x = ibup_mount_imageboss_url($src, $operation, $cover_mode, $width, $height, ibup_add_option($options, 'dpr:3'));
    $new_srcset = "${new_src}, ${new_src_2x} 2x, ${new_src_3x} 3x";

    $img['srcset'] = $new_srcset;
  }

  return str_replace('<?xml version="1.0"?>', '', $img->asXML());

}
