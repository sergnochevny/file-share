"use strict";
(function ($) {
    var companyList = '#company-form select',
        companyForm = '#company-form',
        userList = '#user-list',
        userForm = '#user-form',
        investigationCompanyList = '#investigation-form select',
        investigationForm = '#investigation-form',
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

        } else if ($(this).val() == 'admin'
                || $(this).val() == 'superAdmin'
        ) {
            $('#company-list-container').hide();
            $('#user-list-container').show();

        } else {
            $('#company-list-container').hide();
            $('#user-list-container').hide();
        }
    });

    //when admin add new user - after company was chosen show dropdown with users
    $(document).on('change', '#user-form #company-list', function (event) {
        if ($(this).val() !== '') {
            $('#user-list-container').show();
        } else {
            $('#user-list-container').hide();
        }
    });

    //changes default applicants types when changing company
    $(document).on('change', investigationCompanyList, function (event) {
        var companyId = $(this).val(),
            url = $('#types-container').data('url');

        $.pjax({
            url: url,
            container: '#types-container',
            type: 'get',
            push: false,
            replace: false,
            timeout: 0,
            scrollTo: false,
            data: {companyId: companyId}
        });
    });


    //other


})(jQuery);