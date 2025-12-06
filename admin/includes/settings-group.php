<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('admin_init', 'ibup_register_settings');
function ibup_register_settings() {
    register_setting(
        'imageboss-settings-group',
        'ibup_imageboss_active',
        array(
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    register_setting(
        'imageboss-settings-group',
        'ibup_imageboss_lazyload_active',
        array(
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    register_setting(
        'imageboss-settings-group',
        'ibup_imageboss_hosts',
        array(
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_textarea_field',
        )
    );
    register_setting(
        'imageboss-settings-group',
        'ibup_imageboss_source',
        array(
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
}
