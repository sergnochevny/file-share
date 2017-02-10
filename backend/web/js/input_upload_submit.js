(function ($) {
    $(document).on('change', '[type=file]', function (event) {
        event.preventDefault();
        $('#file-description').modal('show');
    });

    $(document).on('click', '#file-description .upload', function (event) {
        event.preventDefault();
        var form = $('#upload-file'),
            textArea = $('#file-description textarea'),
            inpDescr = document.createElement('input');

        inpDescr.name = textArea.attr('name');
        inpDescr.type = 'hidden';
        inpDescr.value = textArea.val();

        form.prepend(inpDescr);
        form.submit();

    });

    var clearForm = function (event) {
        event.preventDefault();
        $('#upload-file')[0].reset();
    };

    $(document).on('click', '#file-description .close', clearForm);

    $(document).on('click', 'div#file-description', clearForm);
})(jQuery);

