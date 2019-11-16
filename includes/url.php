<?php

function ibup_get_authorised_hosts() {
  return array_filter(
    array_map(
        'trim',
            explode(',',
            get_option('ibup_imageboss_hosts'))
        )
    );
}
function ibup_apply_imageboss_urls($the_content) {
  return preg_replace_callback('/<img[\s\r\n]+.*?>/is', function($matches) {
    return ibup_process_image_fragment($matches[0]);
  }, $the_content);
}

function ibup_get_biggest_size($srcset) {
  $sources = array_map('trim', explode(',', $srcset));
  $size = 0;
  foreach ($sources as $source) {
      $attr = array_map('trim', explode(' ', $source));
      if ($attr[1]) {
          $attr[1] = intval(substr($attr[1], 0, strlen($attr[1]) - 1));
          if ($attr[1] > $size) {
              $retSrc = $attr[0];
              $size = $attr[1];
          }
      }
  }
  return $retSrc;
}

function ibup_process_image_fragment($the_content) {
  $img = simplexml_load_string($the_content);
  $src = clone($img['src']);
  $hosts = join('|', ibup_get_authorised_hosts());

  if (!preg_match("/$hosts/", $src)) {
    return $the_content;
  }

  $transparent_src  = "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=";
  $srcset           = $img['srcset'];

  $img['imageboss-src'] = $src;

  // disable DPR while the library does not fully support srcset
  if (!$img['imageboss-dpr']) {
    $img['imageboss-dpr'] = "false";
  }

  $img['src'] = $transparent_src;

  if ($srcset) {
    $img['imageboss-src'] = ibup_get_biggest_size($srcset);
  }

  return str_replace('<?xml version="1.0"?>', '', $img->asXML());
}
