"use strict";
(function ($) {
    var companyList = '#company-form select',
        companyForm = '#company-form',
        userList = '#user-list',
        userForm = '#user-form',
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

    function updateFormOnListChange(list, form) {
        $(document).on('change', list, function (e) {
            e.preventDefault();
            var id = $(this).val(),
                createUrl = $(form).data('createUrl');

            pjaxSendRequest(createUrl, 'get', {'id': id});
        });
    }

    //Update company
    updateFormOnListChange(companyList, companyForm);

    //update user
    updateFormOnListChange(userList, userForm);


})(jQuery);