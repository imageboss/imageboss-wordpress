(function($) {
  var showOrHideFields = function () {
    var attachment;

    $('.compat-field-cover_mode').hide();
    $('.compat-field-imageboss-width').hide();
    $('.compat-field-imageboss-height').hide()

    var value = $('#operation').val().split('-')[0];

    if (value == 'cover') {
      $('.compat-field-cover_mode').show();
      $('.compat-field-imageboss-width').show();
      $('.compat-field-imageboss-height').show();
    } else if (value == 'width') {
      $('.compat-field-imageboss-width').show();
    } else if (value == 'height') {
      $('.compat-field-imageboss-height').show();
    }
  };

  $(document).on("click", ".attachment", function () {
    showOrHideFields();
    attachment = $(this).attr("data-id");
  });

  $(document).on("change", "#operation", function () {
    showOrHideFields();

    var selected = $("#operation option:selected").val();
    $('input[name="attachments[' + attachment + '][imageboss-operation]"]').val(selected).trigger('change');
  });

  $(document).on("keyup", ".compat-item input", function () {
    $(this).trigger('change');
  });

  $(document).on("change", "#cover_mode", function () {
    var selected = $("#cover_mode option:selected").val();
    $('input[name="attachments[' + attachment + '][imageboss-cover-mode]"]').val(selected).trigger('change');
  });
})(jQuery);
