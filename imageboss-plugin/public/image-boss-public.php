<?php

// wraps the entire blog html output
function ibup_buffer_callback($buffer)
{
  return ibup_apply_imageboss_urls($buffer);
}

add_action('wp_head', 'ibup_buffer_start');

function ibup_buffer_start()
{
  ob_start("ibup_buffer_callback");
}

add_action('wp_footer', 'ibup_buffer_end');
function ibup_buffer_end()
{
  ob_end_flush();
}
