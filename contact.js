

// validation
$(document).ready(function () {

    $("#contact_form").validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            },
            subject: "required",
            message: "required",
            age: "required"

        }, messages: {
            name: {
                required: " First name is Required",
                minlength: " First name requires atleast 3 char"
            },
            email: {
                required: " Email is required",
                email: " Enter valid Email"
            },
            subject: "Subject is required",
            message: "Message is required",
            age: "Age is required"
        }
    });

});

