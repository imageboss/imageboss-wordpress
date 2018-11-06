jQuery( document ).on( 'tinymce-editor-init', function( event, editor ) {
    add_imageboss_url();
    
    if (wp.media) {
        wp.media.view.Modal.prototype.on('open', function() {
            
            var selection = wp.media.frame.state().get('selection');
            
            selection.on( 'selection:single', function ( event ) {
                jQuery('#operation').trigger('change');
                

            } );
        });
    }

    tinymce.activeEditor.on('SetContent', function (e) {
        add_imageboss_url(); 
    });
    
});

function add_imageboss_url() {
    var images = jQuery('.mce-container').contents().find('iframe').contents().find('img');
    images.each((i, img) => {
        var elm = jQuery(img);
        var src = elm.attr('src');
        var cover_mode = '';
        

        if (elm.attr('imageboss-operation') == 'cover') {
            var ib_option;
            var ib_width = elm.attr('imageboss-width');
            var ib_height = elm.attr('imageboss-height');
            if (elm.attr('cover-mode') != '') {
                cover_mode = ':' + elm.attr('cover-mode');
            }
            
            if (elm.attr('imageboss-option') != '' && typeof elm.attr('imageboss-option') !== 'undefined') {
                ib_option = elm.attr('imageboss-option') + '/';
            }else{
                
                ib_option = '';
            }
            elm.attr('src', `https://img.imageboss.me/cover${cover_mode}/${ib_width}x${ib_height}/${ib_option}${src}`);
        } else if (elm.attr('imageboss-operation') == 'width') {
            var ib_option;
            var ib_width = elm.attr('imageboss-width');
            if (elm.attr('cover-mode') != '') {
                cover_mode = ':' + elm.attr('cover-mode');
            }
            
            if (elm.attr('imageboss-option') != '' && typeof elm.attr('imageboss-option') !== 'undefined') {
                ib_option = elm.attr('imageboss-option') + '/';
            }else{
                
                ib_option = '';
            }
            elm.attr('src', `https://img.imageboss.me/width/${ib_width}/${ib_option}${src}`);
        } else if (elm.attr('imageboss-operation') == 'height') {
            var ib_option;
            
            var ib_height = elm.attr('imageboss-height');
            
            if (elm.attr('cover-mode') != '') {
                cover_mode = ':' + elm.attr('cover-mode');
            }
            
            if (elm.attr('imageboss-option') != '' && typeof elm.attr('imageboss-option') !== 'undefined') {
                ib_option = elm.attr('imageboss-option') + '/';
            }else{
                
                ib_option = '';
            }
            elm.attr('src', `https://img.imageboss.me/height/${ib_height}/${ib_option}${src}`);
        } else {
            var ib_option;
            
            if (elm.attr('imageboss-option') != '' && typeof elm.attr('imageboss-option') !== 'undefined') {
                ib_option = elm.attr('imageboss-option') + '/';
            }else{
                
                ib_option = '';
            }
            elm.attr('src', `https://img.imageboss.me/cdn/${ib_option}${src}`);
        }


    });
}