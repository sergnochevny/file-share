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
        //$.waitloader('show');
        if (checkboxes.length > 0 && url) {
            $.ajax({
                'url': url,
                'method': 'POST',
                'data': checkboxes.serialize(),
                'error': function (data) {
                    // $.waitloader('remove');
                    var response = JSON.parse(data.responseText);
                    alert(response.message);
                    console.log(data.responseText);
                },
                'success': function (data) {
                    // $.waitloader('remove');

                    if (data.downloadUrl) {
                        window.location = data.downloadUrl
                        return;
                    }

                    alert('Error');
                }
            });
            return;
        }
        // $.waitloader('remove');
        console.log('Cannot download, checkboxes unchecked or url does\'n set');
    });


})(jQuery);