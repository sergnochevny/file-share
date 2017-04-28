(function ($) {
    var alert = $('.alert-container');
    alert.insertAfter('.layout-sidebar');

    setTimeout(function () {
        alert.hide(400, function () {
            alert.remove();
        });
    }, 11001);
})(jQuery);