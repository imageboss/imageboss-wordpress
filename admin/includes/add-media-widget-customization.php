<?php

add_filter('attachment_fields_to_edit', 'ibup_add_media_custom_field', 10, 2);
function ibup_add_media_custom_field($form_fields, $post) {

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

  $form_fields['imageboss-cover-mode'] = array(
    'label' => __('Cover Mode'),
    'input' => 'hidden',
  );

  $form_fields['cover_mode'] = array(
    'label' => '',
    'input' => 'html',
  );

  $form_fields['cover_mode']['html'] = '<select id="cover_mode" name="cover_mode">';
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

  $form_fields['imageboss-width'] = array(
    'label' => __('Width'),
    'input' => 'text',
    'value' => '',
  );

  $form_fields['imageboss-height'] = array(
    'label' => __('Height'),
    'input' => 'text',
    'value' => '',
  );

  $form_fields['imageboss-operation'] = array(
    'label' => __('Operation'),
    'input' => 'hidden',
    'value' => '',
  );

  $form_fields['imageboss-options'] = array(
    'label' => __('Options'),
    'input' => 'text',
    'value' => '',
  );

  return $form_fields;
}

add_filter('attachment_fields_to_save', 'ibup_save_attachment_field', 10, 2);
function ibup_save_attachment_field($post, $attachment) {
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

add_filter('image_send_to_editor', 'ibup_custom_html_template', 1, 8);
function ibup_custom_html_template($html, $id, $caption, $title, $align, $url, $size, $alt) {
  list($img_src, $width, $height) = image_downsize($id, $size);
  $original_image = wp_get_attachment_image_src($id, 'full');

  $image = new DOMDocument();
  $image->loadXML($html);
  $imgs = $image->getElementsByTagName('img');

  foreach ($imgs as $img) {
    $field_operation = get_post_meta($id, 'imageboss-operation', true);
    $field_cover_mode = get_post_meta($id, 'imageboss-cover-mode', true);
    $field_width = get_post_meta($id, 'imageboss-width', true);
    $field_height = get_post_meta($id, 'imageboss-height', true);
    $field_options = get_post_meta($id, 'imageboss-options', true);

    if ($field_operation) {
      // only when the user selects a operation we should use the original image
      $img->setAttribute('src', $original_image[0]);
      $img->setAttribute('imageboss-operation', $field_operation);
    }

    if ($field_cover_mode) {
      $img->setAttribute('imageboss-cover-mode', $field_cover_mode);
    }

    if ($field_width) {
      $img->setAttribute('imageboss-width', $field_width);
    }

    if ($field_height) {
      $img->setAttribute('imageboss-height', $field_height);
    }

    if ($field_options) {
      $img->setAttribute('imageboss-options', $field_options);
    }

  }

  return $image->saveHTML();
}

add_filter('tiny_mce_before_init', 'ibup_override_mce_options');
function ibup_override_mce_options($initArray) {
  $opts = '*[*]';
  $initArray['valid_elements'] = $opts;
  $initArray['extended_valid_elements'] = $opts;
  return $initArray;
}

add_action('media_buttons', 'ibup_reset_attribute_of_images');
function ibup_reset_attribute_of_images() {
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
