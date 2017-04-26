(function ($) {
    $(document).on('change', '[type=file]', function (event) {
        event.preventDefault();
        //$('#file-description').modal('show');
        $(this).closest('form').trigger('submit');
    });

    $(document).on('pjax:complete', function() {
        $('#file-description').modal('hide');
    });

    $(document).on('click', '#photo-upload', function (event) {
        $('#upload-file').trigger('submit');
    });

    var clearForm = function (event) {
        $('#upload-file')[0].reset();
    };

    $(document).on('hide.bs.modal', '#file-description', clearForm);

})(jQuery);

