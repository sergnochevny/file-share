(function ($) {
    var link = document.createElement('a');
    if (link.download != undefined) {
        $('a[data-download]').each(function () {
            var self = $(this);
            self.on('click', function (event) {
                $('body').waitloader('show');
                var href = self.attr('href');
                $.get(href)
                    .complete(function (res) {
                        $('body').waitloader('remove');
                    });
                return false;
            });
        });
    }
})(jQuery);