(function ($) {

    /**
     * Creates button Download All on checked
     */
    $(document).on('change', '.multi-download, .select-on-check-all', function () {
        var btn = '&nbsp;';

        if ($('.multi-download:checked').length > 0) {
            btn = document.createElement('a')
            btn.className = 'btn btn-warning btn-xs';
            btn.innerHTML = 'Download All';
            btn.id = 'download-all';
        }

        $('th.action-column').html(btn);
    });

    /**
     * Sends selected file ids to server and then redirect to returned download url
     */
    $(document).on('click', '#download-all', function () {
        var checkboxes = $('.multi-download'),
            url = $('#selection-col').data('download-url');

        if (checkboxes.length > 0 && url) {
            $.ajax({
                'url': url,
                'method': 'POST',
                'data': checkboxes.serialize(),
                'error': function (data) {
                    console.log(data.responseText);
                },
                'success': function (data) {
                    console.log(data.downloadUrl);
                }
            });
            return;
        }
        console.log('Cannot download, checkboxes unchecked or url does\'n set');
    });


})(jQuery);