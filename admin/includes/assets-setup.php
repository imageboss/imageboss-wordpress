<?php

add_action('admin_enqueue_scripts', 'ibup_load_assets');
function ibup_load_assets() {
    wp_enqueue_script('imageboss', plugin_dir_url(__FILE__) . '../js/url.js');
    wp_enqueue_script('imageboss', plugin_dir_url(__FILE__) . '../js/add-media.js');
    wp_enqueue_style('imageboss', plugin_dir_url(__FILE__) . '../css/admin_style.css');
}

add_action('admin_footer', 'ibup_admin_assets_js');
function ibup_admin_assets_js() {
    echo '<script type="text/javascript" src="' . plugin_dir_url(__FILE__) . '../js/tinymce-preview.js' . '"></script>';
    echo '<script type="text/javascript" src="' . plugin_dir_url(__FILE__) . '../js/add-media.js' . '"></script>';
    echo '<script type="text/javascript">window.AUTO_IMAGEBOSS_CDN = "' . get_option('ibup_auto_imageboss_cdn') . '";</script>';
}
