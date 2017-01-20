//company send
$('#company-save').on('click', function (e) {
    var companyForm,
        sendRequest;

    sendRequest = function () {
        console.log('Sended');
        window.location.href = window.location.href;
    };

    companyForm = $('#company-form');
    companyForm.on("beforeSubmit", function () {
        sendRequest();
        return false; // Cancel form submitting.
    });
    companyForm.yiiActiveForm('validate', true);
});