function request() {
    jQuery.ajax({
        method: "POST",
        url: sandbox_var.url,
        data: {
            "action": "kronosexpress_create_sandbox_action",
            "firstname": jQuery("#firstname").val(),
            "surname": jQuery("#surname").val(),
            "email": jQuery("#email").val(),
            "nonce": sandbox_var.nonce
        },
        success: function (value) {
            if (value == "ok") {
                jQuery("#requestform").fadeOut(function (){
                    jQuery("#success").fadeIn();
                });
            }
            else {
                alert(value);
            }
        },
        error: function (a, b, c) {
            alert("ΣΦΑΛΜΑ: ΠΙΕΣΤΕ F5");
        }
    }).done(function () {

    })
}