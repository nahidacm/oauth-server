<script>
    /** 
     * This method for submiting a form. First Include the file in push(js) from blade. then call the function with params.
     * @param   formId              main form element ID
     * @param   submitButtonId      submit button element ID
     * @param   postUrl             submit URL(post type) 
     * @param   redirectUrl         after success redirect to the url (get type)
     **/


    /**
     * @param   errors    validation error data from ajax request, array
     * @return            returns error listing, string
     */
    function getErrorHtml($errors) {
        var errorsHtml = '';
        $.each($errors, function(key, value) {

            if (value.constructor === Array) {
                $.each(value, function(i, v) {

                    $("#id_" + key).show().html(v);
                    errorsHtml += '<li>' + v + '</li>';
                });
            } else {
                errorsHtml += '<li>' + value[0] + '</li>';
            }
        });
        return errorsHtml
    }



    function formPost(formId, submitButtonId, postUrl, redirectUrl) {
        formId = "#" + formId;
        submitButtonId = "#" + submitButtonId;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var form = $(formId);
        var submitButton = $(formId + " input[type=submit]");
        Pace.restart();
        Pace.track(function() {
            $.ajax({
                url: postUrl,
                type: "POST",
                data: new FormData(form[0]),
                contentType: false,
                processData: false,
                dataType: "json",
                beforeSend: function() {
                    $(submitButtonId).prop('disabled', true);

                },
                success: function(data) {

                    if (data.code == 200) {
                        $(submitButtonId).html('<i class="fa fa-spinner fa-spin"> </i>' +
                            data.message);
                        $(submitButtonId).prop('disabled', true);
                        $.toast({
                            heading: 'Success',
                            text: data.message,
                            position: 'top-right',
                            stack: false,
                            showHideTransition: 'fade',
                            icon: 'success',
                            hideAfter: 5000
                        });
                        window.setTimeout(function() {
                            window.location.href = redirectUrl;
                        }, 5000);
                    } else if (data.code == 422) {
                        $.toast({
                            heading: data.message,
                            text: getErrorHtml(data.errors),
                            position: 'top-right',
                            stack: false,
                            showHideTransition: 'fade',
                            icon: 'error',
                            hideAfter: 10000,
                        });
                    } else {
                        $.toast({
                            heading: 'Error',
                            text: data.message,
                            position: 'top-right',
                            stack: false,
                            showHideTransition: 'fade',
                            icon: 'error',
                            hideAfter: 5000
                        });
                    }
                },
                complete: function(data) {
                    $(submitButtonId).prop('disabled', false);
                }

            });

        });



    }
</script>