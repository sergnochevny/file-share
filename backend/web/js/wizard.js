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
                createUrl = $(form).data('createUrl'),
                data = {};

            if (id) {
                data.id = id;
            }

            pjaxSendRequest(createUrl, 'get', data);
        });
    }

    //Update company
    updateFormOnListChange(companyList, companyForm);

    //update user
    updateFormOnListChange(userList, userForm);

    //hide some selects when chosen role is not client
    $(document).on('change', '#user-role', function (ev) {
        ev.preventDefault();

        if ($(this).val() == 'client') {
            $('#company-list-container').show();
            $('#user-list-container').show();

        } else if ($(this).val() == 'admin') {
            $('#company-list-container').hide();
            $('#user-list-container').show();

        } else {
            $('#company-list-container').hide();
            $('#user-list-container').hide();
        }
    });

})(jQuery);