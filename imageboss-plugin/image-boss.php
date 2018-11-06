<?php
/*
Plugin Name: ImageBoss
Version: 1.0.2
Author: ImageBoss
Author URI: https://imageboss.me
*/

register_activation_hook(__FILE__, 'ib_plugin_activate');
add_action('admin_init', 'my_plugin_redirect');

function ib_plugin_activate()
{
    add_option('my_plugin_do_activation_redirect', true);
}

function my_plugin_redirect()
{
    if (get_option('my_plugin_do_activation_redirect', false)) {
        delete_option('my_plugin_do_activation_redirect');
        if (!isset($_GET['activate-multi'])) {
            wp_redirect("admin.php?page=image-boss-setting");
        }
    }
}

function imageboss_js()
{
    wp_add_inline_script('mytheme-typekit', 'try{Typekit.load({ async: true });}catch(e){}');
    wp_enqueue_script('image-boss', plugins_url('/js/image-boss-js.js', __FILE__));
    wp_enqueue_style('image-boss', plugins_url('/css/admin_style.css', __FILE__));
}

add_action('admin_enqueue_scripts', 'imageboss_js');

function custom_admin_js()
{
    $url = plugins_url('/js/image-boss-custom-js.js', __FILE__);
    echo '<script type="text/javascript" src="' . $url . '"></script>';
    echo '<script type="text/javascript">window.AUTO_IMAGEBOSS_CDN = "' . get_option('auto_imageboss_cdn') . '";</script>';
}
add_action('admin_footer', 'custom_admin_js');

add_action('admin_menu', 'register_menu_page');

function register_menu_page()
{
    add_menu_page(
        'Dashboard',
        'ImageBoss',
        'manage_options',
        'image-boss',
        'image_boss_main_page'
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

add_action('admin_init', 'register_mysettings');

function register_mysettings() {
    register_setting('imageboss-settings-group', 'auto_imageboss_cdn');
}

function image_boss_main_page()
{
    ?>
<div class="wrap">
<h3>Welcome to ImageBoss</h3>
<table class="form-table">
    <tr valign="top">
    <th scope="row" style="width: 30%;">Create a account in ImageBoss: </th>
    <td><a class='button-primary b-text' target='_blank' href='https://imageboss.me/users/sign_up'>Create Account</a></td>
    </tr>
    <tr valign="top">
    <th scope="row" style="width: 30%;">ImageBoss Documentation:</th>
    <td><a class='button-primary b-text' target='_blank' href='https://imageboss.me/docs'>ImageBoss Docs</a></td>
    </tr>
    <tr valign="top">
    <th scope="row" style="width: 30%;">ImageBoss Dashboard:</th>
    <td><a class='button-primary b-text' target='_blank' href='https://imageboss.me/dashboard'>ImageBoss Dashboard</a></td>
    </tr>
</table>
</div>
<?php }

function image_boss_settings() {
?>

<?php
if ($_GET['action'] == 'image-boss-welcome-screen') {
        echo "<h3>Welcome to ImageBoss</h3>";
        $url = site_url();
        echo "<h3>Please check the host " . $url . " is on the list of authorised hosts on the <a target='_blank' href='https://imageboss.me/dashboard'>ImageBoss Dashboard</a></h3>";
        echo "<p class='b-text'>You have a ImageBoss Account?<p>";

        ?>
  <form method="post" action="options.php" id="welcome_image_boss_settings">
    <?php settings_fields('imageboss-settings-group');?>
    <?php do_settings_sections('imageboss-settings-group');?>
    <table class="form-table">
        <tr valign="top"  style="display: none;">
        <td><input type="checkbox" id="auto_imageboss_cdn" name="auto_imageboss_cdn" value="yes" <?php if ($_POST['auto_imageboss_cdn'] == 'yes') {
            echo 'checked';
        }
        ?>/></td>
        </tr>
    </table>

    <input type="submit" id="aei-im" class="button-primary" value="Yes"> &nbsp;&nbsp;<a class='button-primary b-text' href="<?php echo admin_url('admin.php?page=image-boss-setting'); ?>"> No </a>

</form>
<?php if (isset($_GET['settings-updated'])) { ?>
<script>
    window.location = "<?php echo admin_url('admin.php?page=image-boss-setting'); ?>";
</script>
<?php } ?>
<?php
} else {
  if (get_option('auto_imageboss_cdn') == '') {
?>
  <form method="post" action="<?php echo admin_url('admin.php?page=image-boss-setting&action=image-boss-welcome-screen') ?>" id="image_boss_settings">
<?php } else { ?>
<form method="post" action="options.php" id="image_boss_settings">
<?php } ?>

<div class="wrap">
<h3>ImageBoss Settings</h3>
<?php if (isset($_GET['settings-updated'])) {
  echo "<div class='updated'><p>You have successfully saved the settings.</p></div>";
} ?>

<?php settings_fields('imageboss-settings-group');?>
<?php do_settings_sections('imageboss-settings-group');?>
  <table class="form-table">
    <tr valign="top">
    <th scope="row" style="width: 40%;">Automatically use ImageBoss CDN for all my images</th>
    <td>
      <input type="checkbox" id="auto_imageboss_cdn" name="auto_imageboss_cdn" value="yes" <?php if (get_option('auto_imageboss_cdn') != '') {
        echo 'checked';
      }
      ?> />
    </td>
    </tr>
  </table>

  <input type="submit" class="button-primary" value="Save Changes">
  </form>
</div>
<?php
}
}

function imageboss_add_media_custom_field($form_fields, $post)
{

    $form_fields['imageBoss-configuration'] = array(
        'label' => 'ImageBoss Configuration',
    );

    $form_fields['operation'] = array(
        'label' => 'Operation',
        'input' => 'html',
    );

    $form_fields['operation']['html'] = '<select name="operation" id="operation">';
    $form_fields['operation']['html'] .= '<option value="">Select Operation</option>';
    $form_fields['operation']['html'] .= '<option value="cdn">cdn</option>';
    $form_fields['operation']['html'] .= '<option value="cover">cover</option>';
    $form_fields['operation']['html'] .= '<option value="width">width</option>';
    $form_fields['operation']['html'] .= '<option value="height">height</option>';
    $form_fields['operation']['html'] .= '</select>';

    $imageboss_cover_mode = get_post_meta($post->ID, 'imageboss-cover-mode', true);
    $form_fields['imageboss-cover-mode'] = array(
        'label' => __('Cover Mode'),
        'input' => 'hidden',
    );

    $form_fields['cover_mode'] = array(
        'label' => '',
        'input' => 'html',
    );

    $form_fields['cover_mode']['html'] = '<select id="blue" style="display:none;" name="cover_mode">';
    $form_fields['cover_mode']['html'] .= '<option value="">Select Cover Modes</option>';
    $form_fields['cover_mode']['html'] .= '<option value="center">center</option>';
    $form_fields['cover_mode']['html'] .= '<option value="smart">smart</option>';
    $form_fields['cover_mode']['html'] .= '<option value="attention">attention</option>';
    $form_fields['cover_mode']['html'] .= '<option value="entropy">entropy</option>';
    $form_fields['cover_mode']['html'] .= '<option value="face">face</option>';
    $form_fields['cover_mode']['html'] .= '<option value="north">north</option>';
    $form_fields['cover_mode']['html'] .= '<option value="northeast">northeast</option>';
    $form_fields['cover_mode']['html'] .= '<option value="east">east</option>';
    $form_fields['cover_mode']['html'] .= '<option value="southeast">southeast</option>';
    $form_fields['cover_mode']['html'] .= '<option value="south">south</option>';
    $form_fields['cover_mode']['html'] .= '<option value="southwest">southwest</option>';
    $form_fields['cover_mode']['html'] .= '<option value="west">west</option>';
    $form_fields['cover_mode']['html'] .= '<option value="northwest">northwest</option>';
    $form_fields['cover_mode']['html'] .= '</select></div>';

    $imageboss_width = get_post_meta($post->ID, 'imageboss-width', true);
    $form_fields['imageboss-width'] = array(
        'label' => __('Width'),
        'input' => 'text',
        'value' => '',
    );

    $imageboss_height = get_post_meta($post->ID, 'imageboss-height', true);
    $form_fields['imageboss-height'] = array(
        'label' => __('Height'),
        'input' => 'text',
        'value' => '',
    );
    $imageboss_opt = get_post_meta($post->ID, 'imageboss-operation', true);
    $form_fields['imageboss-operation'] = array(
        'label' => __('Operation'),
        'input' => 'hidden',
        'value' => '',
    );
    $imageboss_options = get_post_meta($post->ID, 'imageboss-options', true);
    $form_fields['imageboss-options'] = array(
        'label' => __('Options'),
        'input' => 'text',
        'value' => '',
    );
    return $form_fields;
}

add_filter('attachment_fields_to_edit', 'imageboss_add_media_custom_field', 10, 2);

function imageboss_save_attachment_field($post, $attachment)
{
    if (isset($attachment['imageboss-height'])) {
        update_post_meta($post['ID'], 'imageboss-height', $attachment['imageboss-height']);
    }
    if (isset($attachment['imageboss-width'])) {
        update_post_meta($post['ID'], 'imageboss-width', $attachment['imageboss-width']);
    }
    if (isset($attachment['imageboss-operation'])) {
        update_post_meta($post['ID'], 'imageboss-operation', $attachment['imageboss-operation']);
    }
    if (isset($attachment['imageboss-cover-mode'])) {
        update_post_meta($post['ID'], 'imageboss-cover-mode', $attachment['imageboss-cover-mode']);
    }
    if (isset($attachment['imageboss-options'])) {
        update_post_meta($post['ID'], 'imageboss-options', $attachment['imageboss-options']);
    }

    return $post;
}

add_filter('attachment_fields_to_save', 'imageboss_save_attachment_field', 10, 2);

function imageboss_custom_html_template($html, $id, $caption, $title, $align, $url, $size, $alt)
{

    list($img_src, $width, $height) = image_downsize($id, $size);
    $hwstring = image_hwstring($width, $height);

    $image_boss = wp_get_attachment_image_src($id, 'full');

    if ($url) {
        $out .= '<a href="' . $url . '" class="fancybox">';
    }

    $field_operation = get_post_meta($id, 'imageboss-operation', true);

    if ($field_operation == 'cover') {
        $field_width = get_post_meta($id, 'imageboss-width', true);
        $field_height = get_post_meta($id, 'imageboss-height', true);
        $field_cover_mode = get_post_meta($id, 'imageboss-cover-mode', true);
        $field_options = get_post_meta($id, 'imageboss-options', true);
        $abd = 'cover-mode="' . $field_cover_mode . '"';

        $out .= '<img src="' . $image_boss[0] . '" alt="' . $alt . '" imageboss-operation="' . $field_operation . '" ' . $abd . ' imageboss-width="' . $field_width . '" imageboss-height="' . $field_height . '" imageboss-options="' . $field_options . '"/>';

    } elseif ($field_operation == 'width') {

        $field_width = get_post_meta($id, 'imageboss-width', true);
        $field_options = get_post_meta($id, 'imageboss-options', true);
        $out .= '<img src="' . $image_boss[0] . '" alt="' . $alt . '" imageboss-operation="' . $field_operation . '" imageboss-width="' . $field_width . '" imageboss-options="' . $field_options . '"/>';

    } elseif ($field_operation == 'height') {
        $field_options = get_post_meta($id, 'imageboss-options', true);
        $field_height = get_post_meta($id, 'imageboss-height', true);
        $out .= '<img src="' . $image_boss[0] . '" alt="' . $alt . '" imageboss-operation="' . $field_operation . '" imageboss-height="' . $field_height . '" imageboss-options="' . $field_options . '"/>';
    } elseif ($field_operation == 'cdn') {
        $field_options = get_post_meta($id, 'imageboss-options', true);
        $field_operation = get_post_meta($id, 'imageboss-operation', true);

        $out .= '<img src="' . $image_boss[0] . '" alt="' . $alt . '" imageboss-operation="' . $field_operation . '" imageboss-options="' . $field_options . '" />';
    } else {
        $field_options = get_post_meta($id, 'imageboss-options', true);
        $field_operation = get_post_meta($id, 'imageboss-operation', true);
        $out .= '<img src="' . $image_boss[0] . '" alt="' . $alt . '" imageboss-options="' . $field_options . '" />';
    }

    if ($url) {
        $out .= '</a>';
    }

    return $out; // the result HTML
}

add_filter('image_send_to_editor', 'imageboss_custom_html_template', 1, 8);

function override_mce_options($initArray)
{
    $opts = '*[*]';
    $initArray['valid_elements'] = $opts;
    $initArray['extended_valid_elements'] = $opts;
    return $initArray;
}
add_filter('tiny_mce_before_init', 'override_mce_options');

function reset_attribute_of_images()
{

    $query_images_args = array(
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'post_status' => 'inherit',
        'posts_per_page' => -1,
    );

    $query_images = new WP_Query($query_images_args);

    $images = array();
    foreach ($query_images->posts as $image) {
        $images_id = $image->ID;
        $myvals = get_post_meta($images_id);
        foreach ($myvals as $key => $val) {
            foreach ($val as $vals) {
                if (($key == 'imageboss-operation') || ($key == 'imageboss-width') || ($key == 'imageboss-height') || ($key == 'imageboss-cover-mode') || ($key == 'imageboss-options')) {
                    update_post_meta($images_id, $key, '');
                }
            }
        }
    }

}
add_action('media_buttons', 'reset_attribute_of_images');

function apply_imageboss_images($the_content)
{
    error_reporting(0);
    $service_url = "https://img.imageboss.me";

    // Create a new istance of DOMDocument
    $post = new DOMDocument();
    // Load $the_content as HTML
    $post->loadHTML('<?xml encoding="utf-8">' . $the_content);
    // Look up for all the <img> tags.
    $imgs = $post->getElementsByTagName('img');

    // Iteration time
    foreach ($imgs as $img) {

        $src = $img->getAttribute('src');
        $ib_opt = $img->getAttribute('imageboss-operation');

        if (preg_match('/gravatar/', $src)) {
            continue;
        }

        if ($ib_opt == 'cover') {

            $cover_mode = $img->getAttribute('cover-mode');
            if ($cover_mode != '') {
                $cmode = ":" . $cover_mode;
            }
            $ib_width = $img->getAttribute('imageboss-width');

            $ib_height = $img->getAttribute('imageboss-height');

            $ib_option = $img->getAttribute('imageboss-options');

            if ($ib_option != '') {
                $ib_option_new = $ib_option . "/";
                $my_src = $service_url . "/cover" . $cmode . "/" . $ib_width . "x" . $ib_height . "/" . $ib_option_new . "" . $src;
            } else {
                $my_src = $service_url . "/cover" . $cmode . "/" . $ib_width . "x" . $ib_height . "/" . $src;
            }

            $img->setAttribute('src', $my_src);

        } elseif ($ib_opt == 'cdn') {

            $ib_optionc = $img->getAttribute('imageboss-options');
            if ($ib_optionc != '') {
                $ib_option_newc = $ib_optionc . "/";
                $my_src = $service_url . "/cdn/" . $ib_option_newc . "" . $src;
            } else {
                $my_src = $service_url . "/cdn/" . $src;
            }

            $img->setAttribute('src', $my_src);

        } elseif ($ib_opt == 'width') {

            $ib_width = $img->getAttribute('imageboss-width');

            $ib_optionw = $img->getAttribute('imageboss-options');

            if ($ib_optionw != '') {
                $ib_option_neww = $ib_optionw . "/";
                $my_src = $service_url . "/width/" . $ib_width . "/" . $ib_option_neww . "" . $src;
            } else {
                $my_src = $service_url . "/width/" . $ib_width . "/" . $src;
            }

            $img->setAttribute('src', $my_src);

        } elseif ($ib_opt == 'height') {

            $ib_height = $img->getAttribute('imageboss-height');

            $ib_optionh = $img->getAttribute('imageboss-options');

            if ($ib_optionh != '') {
                $ib_option_newh = $ib_optionh . "/";
                $my_src = $service_url . "/height/" . $ib_height . "/" . $ib_option_newh . "" . $src;
            } else {
                $my_src = $service_url . "/height/" . $ib_height . "/" . $src;
            }

            $img->setAttribute('src', $my_src);

        } else if (get_option('auto_imageboss_cdn') != '') {
            $ib_option2 = $img->getAttribute('imageboss-options');
            if ($ib_option2 != '') {
                $ib_option_new2 = $ib_option2 . "/";
                $my_src = $service_url . "/cdn/" . $ib_option_new2 . "" . $src;
            } else {
                $my_src = $service_url . "/cdn/" . $src;
            }

            $img->setAttribute('src', $my_src);
        }

    }

    return $post->saveHTML();
}


// wraps the entire blog html output
function callback($buffer) {
    return apply_imageboss_images($buffer);
}

function buffer_start() {
    ob_start("callback");
}

function buffer_end() {
    ob_end_flush();
}

add_action('wp_head', 'buffer_start');
add_action('wp_footer', 'buffer_end');
