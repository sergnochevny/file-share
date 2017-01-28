"use strict";
(function ($) {
    var companyList = '#company-form select',
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
            createUrl = $(companyForm).data('createUrl');

        pjaxSendRequest(createUrl, 'get', {'id': companyId});
    });


})(jQuery);