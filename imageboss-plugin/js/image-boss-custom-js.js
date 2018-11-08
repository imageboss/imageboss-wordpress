jQuery( document ).on( 'tinymce-editor-init', function( event, editor ) {
    ibup_add_imageboss_url();

    if (wp.media) {
        wp.media.view.Modal.prototype.on('open', function() {

            var selection = wp.media.frame.state().get('selection');

            selection.on( 'selection:single', function ( event ) {
                jQuery('#operation').trigger('change');
            } );
        });
    }

    tinymce.activeEditor.on('SetContent', function (e) {
        ibup_add_imageboss_url();
    });

});

function ibup_add_imageboss_url() {
    var images = jQuery('.mce-container').contents().find('iframe').contents().find('img');
    images.each((i, img) => {
        var elm = jQuery(img);
        var src = elm.attr('src');
        var cover_mode = '';
        var service_url = 'https://img.imageboss.me';

        if (elm.attr('imageboss-operation') == 'cover') {
            var ibup_option;
            var ibup_width = elm.attr('imageboss-width');
            var ibup_height = elm.attr('imageboss-height');
            if (elm.attr('cover-mode') != '') {
                cover_mode = ':' + elm.attr('cover-mode');
            }

            if (elm.attr('imageboss-options') != '' && typeof elm.attr('imageboss-options') !== 'undefined') {
                ibup_option = elm.attr('imageboss-options') + '/';
            }else{

                ibup_option = '';
            }
            elm.attr('src', `${service_url}/cover${cover_mode}/${ibup_width}x${ibup_height}/${ibup_option}${src}`);
        } else if (elm.attr('imageboss-operation') == 'width') {
            var ibup_option;
            var ibup_width = elm.attr('imageboss-width');
            if (elm.attr('cover-mode') != '') {
                cover_mode = ':' + elm.attr('cover-mode');
            }

            if (elm.attr('imageboss-options') != '' && typeof elm.attr('imageboss-options') !== 'undefined') {
                ibup_option = elm.attr('imageboss-options') + '/';
            }else{

                ibup_option = '';
            }
            elm.attr('src', `${service_url}/width/${ibup_width}/${ibup_option}${src}`);
        } else if (elm.attr('imageboss-operation') == 'height') {
            var ibup_option;

            var ibup_height = elm.attr('imageboss-height');

            if (elm.attr('cover-mode') != '') {
                cover_mode = ':' + elm.attr('cover-mode');
            }

            if (elm.attr('imageboss-options') != '' && typeof elm.attr('imageboss-options') !== 'undefined') {
                ibup_option = elm.attr('imageboss-options') + '/';
            }else{

                ibup_option = '';
            }
            elm.attr('src', `${service_url}/height/${ibup_height}/${ibup_option}${src}`);
        } else if (elm.attr('imageboss-operation') == 'cdn' || window.AUTO_IMAGEBOSS_CDN != '') {
            var ibup_option;

            if (elm.attr('imageboss-options') != '' && typeof elm.attr('imageboss-options') !== 'undefined') {
                ibup_option = elm.attr('imageboss-options') + '/';
            } else {

                ibup_option = '';
            }
            elm.attr('src', `${service_url}/cdn/${ibup_option}${src}`);
        }
    });
}
