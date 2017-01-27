(function ($, undefined) {
    var companyList = '#company-list',
        pjaxContainer = '#wizard-container';



    $(companyList).on('change', function (ev) {
        var companyId,
            url;

        companyId = $(this).val();
        url = $(this).data('infoUrl');
        if (url && companyId) {
            $.pjax({
                url: url,
                container: pjaxContainer,
                type:'get',
                push:false,
                replace:false,
                timeout:0,
                scrollTo:0,
                data: {'id': companyId}
            });

        }
    });


})(jQuery);