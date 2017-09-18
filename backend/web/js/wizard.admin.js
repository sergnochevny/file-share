"use strict";
(function ($) {
    var userList = '#admin-list',
        userForm = '#admin-form',
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

    function clearFormInputs(){
        $(userForm).find('#inputs input').val('');
    }

    function updateFormOnListChange(list, form) {
        $(document).on('change', list, function (e) {
            e.preventDefault();
            var id = $(this).val(),
                createUrl = $(form).data('createUrl'),
                data = {};

            if (id) {
                data.id = id;
                pjaxSendRequest(createUrl, 'get', data);
            } else {
                clearFormInputs();
            }
        });
    }

    //update user
    updateFormOnListChange(userList, userForm);

    //hide some selects when chosen role is not client
    $(document).on('change', '#admin-role', function (ev) {
        ev.preventDefault();

        if ($(this).val() === 'admin' || $(this).val() === 'sadmin') {
            $('#admin-list-container').show();
        } else {
            $('#admin-list-container').hide();
        }
    });

    //when admin add new user - after company was chosen show dropdown with users
    $(document).on('change', '#admin-form #company-list', function (event) {
        if ($(this).val() !== '') {
            $('#admin-list-container').show();
        } else {
            $('#admin-list-container').hide();
        }
    });

    //other services
    $(document).on('change', 'input:checkbox[value=-1]', function () {
        if (this.checked) {
            $('.other').removeClass('hidden');
        } else {
            var other = $('.other');
            other.addClass('hidden');
            other.find('input').val('');
        }
    });

})(jQuery);