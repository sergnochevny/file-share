(function ($) {

    /**
     * Creates button Download All on checked
     */
    $(document).on('change', '.multi-download, .select-on-check-all', function () {
        var actionColumn = $('th.action-column');

        actionColumn.removeAttr('style');
        if ($('.multi-download:checked').length > 0) {
            var btn = document.createElement('a');
            btn.className = 'btn btn-warning btn-xs';
            btn.innerHTML = 'Download All';
            btn.id = 'download-all';
            actionColumn.attr('style', 'text-align: right; padding-right: 50px;')
        }

        (!!btn && actionColumn.html(btn)) || (!btn && actionColumn.html('&nbsp;'));
    });

    /**
     * Sends selected file ids to server and then redirect to returned download url
     */
    $(document).on('click', '#download-all', function () {
        var checkboxes = $('.multi-download'),
            url = $('#selection-col').data('download-url'),
            body = $('body');

        body.waitloader('show');
        if (checkboxes.length > 0 && url) {
            $.ajax({
                'url': url,
                'method': 'POST',
                'data': checkboxes.serialize(),
                'error': function (data) {
                    body.waitloader('remove');
                    var response;
                    try {
                        response = JSON.parse(data.responseText);

                    } catch (err) {
                        response = {message: err.message};
                    }

                    alert(response.message);
                    console.log(data.responseText);
                },
                'success': function (data) {
                    body.waitloader('remove');

                    if (data.downloadUrl) {
                        window.location = data.downloadUrl;
                        return;
                    }

                    alert('Error');
                }
            });
            return;
        }
        body.waitloader('remove');
        console.log('Cannot download, checkboxes unchecked or url does\'n set');
    });


})(jQuery);