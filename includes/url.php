<?php

function ibup_mount_imageboss_url($src, $operation, $cover_mode, $width, $height, $options)
{
  $serviceUrl = 'https://img.imageboss.me';
  $template = '/:operation/:options/';

  if ($operation === 'cover') {
    $template = '/:operation::cover_mode/:widthx:height/:options/';
  } else if ($operation === 'width') {
    $template = '/:operation/:width/:options/';
  } else if ($operation === 'height') {
    $template = '/:operation/:height/:options/';
  }

  $finalUrl = str_replace(':operation', $operation ?: 'cdn', $template);
  $finalUrl = str_replace(':cover_mode', $cover_mode, $finalUrl);
  $finalUrl = str_replace(':width', $width, $finalUrl);
  $finalUrl = str_replace(':height', $height, $finalUrl);
  $finalUrl = str_replace(':options', $options, $finalUrl);
  $finalUrl = preg_replace('/\/\//', '/', $finalUrl);
  $finalUrl = preg_replace('/:\//', '/', $finalUrl);

  return $serviceUrl . $finalUrl . $src;
}

function ibup_apply_cdn($size) {
  return 'https://img.imageboss.me/cdn/' . trim($size);
}

function ibup_add_option($options, $option) {
  $options = array_filter(explode(',', $options));
  array_push($options, $option);
  return implode(',', $options);
}

function ibup_apply_imageboss_urls($the_content)
{
  error_reporting(0);

  // Create a new istance of DOMDocument
  $post = new DOMDocument();
  // Load $the_content as HTML
  $post->loadHTML('<?xml encoding="utf-8">' . $the_content);
  // Look up for all the <img> tags.
  $imgs = $post->getElementsByTagName('img');
  $body = $post->getElementsByTagName('body')->item(0);

  $has_woocommerce = preg_match('/woocommerce/', $body->getAttribute('class'));

  // Iteration time
  foreach ($imgs as $img) {
    $src = $img->getAttribute('src');
    $srcset = $img->getAttribute('srcset');

    if (preg_match('/gravatar/', $src) && !preg_match('/^http/')) {
      continue;
    }

    $operation  = $img->getAttribute('imageboss-operation');
    $cover_mode = $img->getAttribute('imageboss-cover-mode');
    $width      = $img->getAttribute('imageboss-width');
    $height     = $img->getAttribute('imageboss-height');
    $options    = $img->getAttribute('imageboss-options');

    $new_src = ibup_mount_imageboss_url($src, $operation, $cover_mode, $width, $height, $options);
    $img->setAttribute('src', $new_src);

    if ($has_woocommerce && $img->getAttribute('data-src')) {
      $img->setAttribute('data-src', $new_src);
    }

    if ($srcset && !$operation) {
      $sizes = explode(',', $srcset);
      $sizes = array_map('ibup_apply_cdn', $sizes);
      $new_srcset = implode(',', $sizes);
      $img->setAttribute('srcset', $new_srcset);

      if ($has_woocommerce && $img->getAttribute('data-srcset')) {
        $img->setAttribute('data-srcset', $new_srcset);
      }

    // add supoort for retina displays
    } else if ($operation) {
      $new_src_2x = ibup_mount_imageboss_url($src, $operation, $cover_mode, $width, $height, ibup_add_option($options, 'dpr:2'));
      $new_src_3x = ibup_mount_imageboss_url($src, $operation, $cover_mode, $width, $height, ibup_add_option($options, 'dpr:3'));
      $new_srcset = "${new_src}, ${new_src_2x} 2x, ${new_src_3x} 3x";

      $img->setAttribute('srcset', $new_srcset);

      if ($has_woocommerce && $img->getAttribute('data-srcset')) {
        $img->setAttribute('data-srcset', $new_srcset);
      }

    }
  }

  return $post->saveHTML();
}
