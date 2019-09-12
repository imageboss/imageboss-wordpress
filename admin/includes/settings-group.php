<?php

add_action('admin_init', 'ibup_register_settings');
function ibup_register_settings() {
  register_setting('imageboss-settings-group','ibup_auto_imageboss_cdn');
  register_setting('imageboss-settings-group','ibup_auto_imageboss_thumbnails');
}
