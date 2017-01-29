(function ($) {
    $(document).on('change', '[data-submit]', function (event) {
        event.preventDefault();
        debugger;
        $(this).closest('form').trigger('submit');
    });
})(jQuery);

