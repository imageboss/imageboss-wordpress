<?php
// Exit if uninstall not called from WordPress
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

$prefix = 'ibup_';
$options = array('plugin_redirect', 'imageboss_hosts', 'imageboss_source', 'imageboss_active', 'imageboss_lazyload_active');

foreach ( $options as $option ) {
    delete_option( $prefix . $option );
    delete_site_option( $prefix . $option );
}
