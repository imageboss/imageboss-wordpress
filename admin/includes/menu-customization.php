<?php

add_action('admin_menu', 'ibup_register_menu_page');
function ibup_register_menu_page()
{
  add_menu_page(
    'Dashboard',
    'ImageBoss',
    'manage_options',
    'imageboss',
    'ibup_main_page'
  );

  add_submenu_page(
    'imageboss',
    'Settings',
    'Settings',
    'manage_options',
    'imageboss-setting',
    'image_boss_settings'
  );

  add_submenu_page(
    '',
    'Welcome to ImageBoss',
    'Settings',
    'manage_options',
    'imageboss-welcome-screen',
    'image_boss_welcome_screen'
  );
}
