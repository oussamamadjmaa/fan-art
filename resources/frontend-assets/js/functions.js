window._s = {};
_s.validate_input_number = function(evt) {
    var theEvent = evt || window.event;

    // Handle paste
    if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
    } else {
        // Handle key press
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[0-9]|\./;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}

$(document).on('keypress', ".number-input", (e) => validate_input_number(e));

_s.handleFailure = function (fail, elem) {
    let jsonRes = fail.responseJSON;
    $(elem).find('.is-invalid').removeClass('is-invalid');
    if (jsonRes) {
        if (fail.status == 422) {
            if (jsonRes.errors) {
                $.each(jsonRes.errors, function (input, error) {
                    input = input.replaceAll('.', '__');
                    $(elem).find("*[name=" + input + "], #"+input).addClass('is-invalid').parent().find('.invalid-feedback').text(error[0]);
                });
            }
        }
        window.Swal.fire({
            icon: 'error',
            text: jsonRes.message || fail.statusText,
            confirmButtonText: GLOBAL['LANG'] == 'ar' ? 'إغلاق' : 'Close',
        })
    }
}
_s.validateForm = function (formId) {
    let required_inputs = $(formId).find('*[required]');
    let errors_count = 0;
    $.each(required_inputs, function () {
        if (($(this).val()).isEmpty()) {
            errors_count++;
            $(this).addClass('is-invalid').parent().find('.invalid-feedback').text((lang.validation.required).replace(":attribute", ($(this).parent().find('label').text()).replace('*', '')));
        }
    })

    $.each($(formId).find('input[type=email]'), function () {
        if (!($(this).val()).isEmpty() && !_s.ValidateEmail($(this).val())) {
            errors_count++;
            $(this).addClass('is-invalid').parent().find('.invalid-feedback').text((lang.validation.email).replace(":attribute", ($(this).parent().find('label').text()).replace('*', '')));
        }
    })

    if (errors_count) return false;
    return true;
}

_s.ValidateEmail = function (mail) {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) return true;
    return false;
}


String.prototype.isEmpty = function () {
    return (this.length === 0 || !this.trim());
};



