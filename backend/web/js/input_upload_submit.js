(function ($) {
    $(document).on('change', '[type=file]', function (event) {
        event.preventDefault();
        $(this).closest('form').trigger('submit');
    });
})(jQuery);

