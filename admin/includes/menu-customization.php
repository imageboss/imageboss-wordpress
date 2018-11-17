<?php

add_action('admin_menu', 'ibup_register_menu_page');
function ibup_register_menu_page() {
  add_menu_page(
    'Dashboard',
    'ImageBoss',
    'manage_options',
    'imageboss',
    'image_boss_settings',
    'dashicons-welcome-widgets-menus'
  );
}
