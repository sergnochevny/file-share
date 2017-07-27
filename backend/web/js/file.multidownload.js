(function ($) {

    /**
     * Sends selected file ids to server and then redirect to returned download url
     */
    $(document).on('click', '#download-all', function () {
        var _checked_checkboxes = $('.multi-download:checked'),
            _select_col = $('#selection-col'),
            _url = _select_col.data('download-url'),
            _body = $('body');

        _body.waitloader('show');
        if ((_checked_checkboxes.length > 0) && _url) {
            $.ajax({
                'url': _url,
                'method': 'POST',
                'data': _checked_checkboxes.serialize(),
                'error': function (data) {
                    _body.waitloader('remove');
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
                    _body.waitloader('remove');
                    if (data.downloadUrl) {
                        window.location = data.downloadUrl;
                        return;
                    }

                    alert('Error');
                }
            });
            return;
        } else {
            _body.waitloader('remove');
            !_select_col.data('alert') || alert(_select_col.data('alert'));
        }
        _body.waitloader('remove');
        console.log('Cannot download, checkboxes unchecked or url does\'n set');
    });


})(jQuery);