<?php

add_action('admin_menu', 'ibup_register_menu_page');
function ibup_register_menu_page()
{
  add_menu_page(
    'Dashboard',
    'ImageBoss',
    'manage_options',
    'image-boss',
    'ibup_main_page'
  );

  add_submenu_page(
    'image-boss',
    'Settings',
    'Settings',
    'manage_options',
    'image-boss-setting',
    'image_boss_settings'
  );
  add_submenu_page(
    '',
    'Welcome to ImageBoss',
    'Settings',
    'manage_options',
    'image-boss-welcome-screen',
    'image_boss_welcome_screen'
  );
}
