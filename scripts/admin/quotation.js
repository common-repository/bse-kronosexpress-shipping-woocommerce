function request() {
    jQuery.ajax({
        method: "POST",
        url: quotation_var.url,
        data: {
            "action": "kronosexpress_quotation_action_submit",
            "name": jQuery("#name").val(),
            "company": jQuery("#company").val(),
            "tel": jQuery("#tel").val(),
            "email": jQuery("#email").val(),
            "quantity": jQuery("#quantity").val(),
            "comments": jQuery("#comments").val(),
            "nonce": quotation_var.nonce
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