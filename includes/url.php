<?php

function ibup_is_activated() {
  return get_option('ibup_imageboss_active') == "true";
}

function ibup_is_lazyload_activated() {
  return get_option('ibup_imageboss_lazyload_active') == "true";
}

function ibup_get_authorised_hosts() {
  $hosts = htmlspecialchars(get_option('ibup_imageboss_hosts'), ENT_QUOTES, 'UTF-8');
  return array_filter(array_map('trim', explode(',', $hosts)));
}

function ibup_get_source() {
  return trim(get_option('ibup_imageboss_source'));
}

function ibup_apply_imageboss_urls($the_content) {
  $hosts = join('|', array_map(function($host) {
    return preg_quote($host, '/');
  }, ibup_get_authorised_hosts()));

  $the_content = preg_replace_callback('/<img[\s\r\n]+.*?>/is', function($matches) use ($hosts) {
    return ibup_process_image_fragment($matches[0], $hosts);
  }, $the_content);

  $the_content = preg_replace_callback("/<[^>]*?\sstyle=['\"][^>]*?background(-image)?:.*?url\(\s*.*?\s*\);?.*?['\"].*?>/ismS", function($matches)  use ($hosts) {
    return ibup_process_background_fragment($matches[0], $hosts);
  }, $the_content);

  return $the_content;
}

function ibup_process_background_fragment($fragment, $hosts) {
  if (!preg_match("/$hosts/", $fragment)) {
    return $fragment;
  }

  $fragment = preg_replace("/(\sstyle=['\"][^>]*?)(background-image:.*?url\((\s*.*?\s*)\));?(.*?['\"])/xis", '$1$4 data-imageboss-bg-src=$3', $fragment);
  $fragment = preg_replace("/(\sstyle=['\"][^>]*?background:.*?)(url\((\s*.*?\s*)\));?(.*?['\"])/xis", '$1$4 data-imageboss-bg-src=$3', $fragment);

  return $fragment;
}

function ibup_process_image_fragment($img, $hosts) {
  preg_match('/\bsrc[\s\r\n]*=[\s\r\n]*[\'"]?(.*?)[\'">\s\r\n]/xis', $img, $matches);
  $src = $matches[1];

  if (!preg_match("/$hosts/", $src)) {
    return $img;
  }

  $transparent_src  = "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=";
  $lazyload_attr = ibup_is_lazyload_activated() ? ' data-imageboss-class="lazyload"': '';
  $img = preg_replace('/<img(.*?)src=(["\']?).*?[\'">\s\r\n]/is', '<img$1src="' . $transparent_src . '" data-imageboss-src="' . $src . '"'.$lazyload_attr.'', $img);

  return $img;
}
