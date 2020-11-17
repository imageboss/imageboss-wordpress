<?php

add_action('admin_init', 'ibup_register_settings');
function ibup_register_settings() {
    register_setting('imageboss-settings-group', 'ibup_imageboss_active');
    register_setting('imageboss-settings-group', 'ibup_imageboss_lazyload_active');
    register_setting('imageboss-settings-group', 'ibup_imageboss_hosts');
    register_setting('imageboss-settings-group', 'ibup_imageboss_source');
}
