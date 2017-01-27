"use strict";
(function ($) {
    var companyList = '#company-list',
        companyForm = '#company-form',
        pjaxContainer = '#wizard-container';


    function pjaxSendRequest(url, type, data) {
        $.pjax({
            url: url,
            container: pjaxContainer,
            type: type,
            push: false,
            replace: false,
            timeout: 0,
            scrollTo: false,
            data: data
        });
    }


    //Update company
    $(document).on('change', companyList, function (e) {
        e.preventDefault();
        var companyId = $(this).val(),
            infoUrl = $(this).data('infoUrl'),
            createUrl = $(companyForm).data('createUrl');

        if (infoUrl && companyId) {
            pjaxSendRequest(infoUrl, 'get', {'id': companyId});

        } else if (!companyId && createUrl) {
            pjaxSendRequest(createUrl, 'get');
        }
    });


})(jQuery);