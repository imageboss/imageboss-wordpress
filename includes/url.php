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
  return 'https://img.imageboss.me/cdn/' . $size;
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

    // Iteration time
    foreach ($imgs as $img) {
        $src = $img->getAttribute('src');
        $srcset = $img->getAttribute('srcset');

        if (preg_match('/gravatar/', $src)) {
            continue;
        }

        $operation  = $img->getAttribute('imageboss-operation');
        $cover_mode = $img->getAttribute('imageboss-cover-mode');
        $width      = $img->getAttribute('imageboss-width');
        $height     = $img->getAttribute('imageboss-height');
        $options    = $img->getAttribute('imageboss-options');

        $new_src = ibup_mount_imageboss_url($src, $operation, $cover_mode, $width, $height, $options);
        $img->setAttribute('src', $new_src);

        if ($srcset) {
          $sizes = explode(',', $srcset);
          $sizes = array_map('ibup_apply_cdn', $sizes);
          $img->setAttribute('srcset', implode(',', $sizes));
        }

        // TODO: generate srcset if it doesnt exist
        //       using option dpr:1, dpr:2, dpr:3...

    }

    return $post->saveHTML();
}
