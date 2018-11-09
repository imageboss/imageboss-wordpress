<?php

add_action('admin_init', 'ibup_register_mysettings');
function ibup_register_mysettings()
{
    register_setting('imageboss-settings-group', 'ibup_auto_imageboss_cdn');
}
