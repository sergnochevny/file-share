// (function ($, undefined) {
//      USED PJAX
//     //company
//     var companyForm;
//
//     companyForm = $('#company-form');
//     companyForm.on("beforeSubmit", function () {
//         sendRequest(companyForm[0], new FormData(companyForm[0]), function (data) {
//             if (data.status === true) {
//                 console.log('Company created');
//                 //company created
//                 return;
//             }
//
//             //something went wrong
//             return;
//
//         }, function () {
//             console.log('error');
//         });
//
//         return false; // Cancel form submitting.
//     });
//
//     $('#company-create').on('click', function (e) {
//         companyForm.yiiActiveForm('validate', true);
//         return false;
//     });
//
//     /**
//      * Sends requests
//      *
//      * @param {HTMLFormElement} form
//      * @param {FormData} formData
//      * @param {function} success
//      * @param {function} error
//      */
//     function sendRequest(form, formData, success, error) {
//         $.ajax({
//             url: form.action,
//             type: form.method,
//             data: formData,
//             processData: false,
//             contentType: false,
//             success: success,
//             error: error
//         });
//     }
// })(jQuery);

(function($){
    $(document).on('click', '.sidebar-toggle', function() {
        $(document.body).toggleClass('menu-open');
    });
})(jQuery);