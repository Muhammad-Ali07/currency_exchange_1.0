/*=========================================================================================
  File Name: auth-login.js
  Description: Auth login js file.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: PIXINVENT
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
    'use strict';

    var pageLoginForm = $('#default_branch_store');

    // jQuery Validation
    // --------------------------------------------------------------------
    if (pageLoginForm.length) {
        $.validator.addMethod("valueNotEquals", function(value, element, arg){
            return arg !== value;
        }, "This field is required");
        pageLoginForm.validate({
            /*
            * ? To enable validation onkeyup
            onkeyup: function (element) {
              $(elem  ent).valid();
            },*/
            /*
            * ? To enable validation on focusout
            onfocusout: function (element) {
              $(element).valid();
            }, */
            rules: {
                branch_id: {
                    required: true,
                    valueNotEquals: "0",
                },
            },
            submitHandler: function (form) {
                pageLoginForm.find(":submit").prop('disabled', true);
                //form[0].submit(); // submit the form
                var formData = new FormData(form);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url         : form.action,
                    type        : form.method,
                    dataType	: 'json',
                    data        : formData,
                    cache       : false,
                    contentType : false,
                    processData : false,
                    success: function(response,status) {
                        console.log(response);
                        if(response.status == 'success'){
                            ntoastr.success(response.message);
                            setTimeout(function () {
                                $("form").find(":submit").prop('disabled', false);
                            }, 2000);
                            window.location.href = response.data.url;
                        }else{
                            ntoastr.error(response.message);
                            setTimeout(function () {
                                pageLoginForm.find(":submit").prop('disabled', false);
                            }, 2000);
                        }
                    },
                    error: function(response,status) {
                        // console.log(response.responseJSON);
                        if(response.responseJSON.message !== undefined){
                            ntoastr.error(response.responseJSON.message);
                        }
                        setTimeout(function () {
                            $("form").find(":submit").prop('disabled', false);
                        }, 2000);
                    },
                });
            }
        });
    }
});
