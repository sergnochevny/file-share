(function ($) {
    !$ || $(document).on('click', 'a[data-download]', function (event) {
        event.preventDefault();
        $.get($(this).attr('href'));
    });
})(jQuery);