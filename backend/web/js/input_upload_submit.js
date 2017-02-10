(function ($) {
    $(document).on('change', '[type=file]', function (event) {
        event.preventDefault();
        $('#file-description').modal('show');
    });

    $(document).on('click', '#photo-upload', function (event) {
        event.preventDefault();
        event.stopPropagation();
        var form = $('#upload-file'),
            textArea = $('#file-description textarea'),
            inpDescr = document.createElement('input');

        inpDescr.name = textArea.attr('name');
        inpDescr.type = 'hidden';
        inpDescr.value = textArea.val();

        form.prepend(inpDescr);
        form.submit();
    });

    //fix - when clicked on textarea, clearForm called,
    // because of event propagation to click on div#file-description
    $(document).on('click', '#modal-file-description', function () {
        return false;
    });

    var clearForm = function (event) {
        event.preventDefault();
        $('#upload-file')[0].reset();
    };

    $(document).on('click', '#file-description .close', clearForm);

    $(document).on('click', 'div#file-description', clearForm);
})(jQuery);

