var ht;



jQuery(document).on("click", ".attachment", function(){

ht = jQuery(this).attr("data-id");

});



jQuery(document).on("change", "#operation", function(){



    var selectedText2 =  jQuery("#operation option:selected").text();

    jQuery('input[name="attachments['+ht+'][imageboss-opt]"]').val(selectedText2).trigger('change');



    value = jQuery(this).val().split('-')[0]; // extracting the color prefix from selected value

    if(value == 'cover'){

        jQuery('#blue').show(); //showing div having id"blue"

        jQuery('.compat-field-imageboss-width').show();

        jQuery('.compat-field-imageboss-height').show();

    }

    else if(value == 'width') {

        jQuery('.compat-field-imageboss-width').show();

        jQuery('.compat-field-imageboss-height').hide();

        jQuery('#blue').hide();

    }

    else if(value == 'height') {

        jQuery('.compat-field-imageboss-height').show();

        jQuery('.compat-field-imageboss-width').hide();

        jQuery('#blue').hide();

    }

    else // if selected value have prefix other than Blue 

    {

        jQuery('#blue').hide(); //hide the div having id "blue"

        jQuery('.compat-field-imageboss-width').hide();

        jQuery('.compat-field-imageboss-height').hide();

    }



});


jQuery(document).on("keyup", ".compat-item input", function(){

    jQuery(this).trigger('change');

});

jQuery(document).on("change", "#blue", function(){

    var selectedText2 =  jQuery("#blue option:selected").text();

    jQuery('input[name="attachments['+ht+'][imageboss-cover-mode]"]').val(selectedText2).trigger('change');

});

