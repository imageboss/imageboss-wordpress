jQuery(document).on('tinymce-editor-init', function (event, editor) {
  ibup_add_imageboss_url();

  if (wp.media) {
    wp.media.view.Modal.prototype.on('open', function () {

      var selection = wp.media.frame.state().get('selection');

      selection.on('selection:single', function (event) {
        jQuery('#operation').trigger('change');
      });
    });
  }

  tinymce.activeEditor.on('SetContent', function (e) {
    ibup_add_imageboss_url();
  });

});

function ibup_mountImageBossUrl(src, { operation, cover_mode, width, height, options }) {
  var serviceUrl = 'https://img.imageboss.me';
  var template = '/:operation/:options/';

  if (operation === 'cover') {
    template = '/:operation::cover_mode/:widthx:height/:options/';
  } else if (operation === 'width') {
    template = '/:operation/:width/:options/';
  } else if (operation === 'height') {
    template = '/:operation/:height/:options/';
  }

  var finalUrl = template
    .replace(':operation', operation || 'cdn')
    .replace(':cover_mode', cover_mode || '')
    .replace(':width', width || '')
    .replace(':height', height || '')
    .replace(':options', options || '')
    .replace(/\/\//g, '/')
    .replace(/:\//g, '/')

    return serviceUrl + finalUrl + src;
}

function ibup_add_imageboss_url() {
  var images = jQuery('.mce-container').contents().find('iframe').contents().find('img');
  images.each((i, img) => {
    var elm = jQuery(img);
    var src = elm.attr('src');
    var newUrl = ibup_mountImageBossUrl(src, {
      operation: elm.attr('imageboss-operation'),
      cover_mode: elm.attr('cover-mode'),
      width: elm.attr('imageboss-width'),
      height: elm.attr('imageboss-height'),
      options: elm.attr('imageboss-options'),
    });

    console.log(newUrl);
    elm.attr('src', newUrl);
  });
}
