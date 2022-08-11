function validate_input_number(evt) {
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

handleFailure = function (fail) {
    let jsonRes = fail.responseJSON;
    $(dataFormId).find('.is-invalid').removeClass('is-invalid');
    if (jsonRes) {
        if (fail.status == 422) {
            if (jsonRes.errors) {
                $.each(jsonRes.errors, function (input, error) {
                    $(dataFormId).find("*[name=" + input + "]").addClass('is-invalid').parent().find('.invalid-feedback').text(error);
                });
            }
        }
        if (jsonRes.message) {
            toastr.error(jsonRes.message);
        } else {
            toastr.error(fail.statusText);
        }
    }
}

setRequiredInputsStar = function () {
    let required_inputs = $(document).find('*[required]');
    $.each(required_inputs, function () {
        $(this).parent().find('label').append(`<span class="text-danger">*</span>`);
    })
}

validateForm = function (formId) {
    let required_inputs = $(formId).find('*[required]');
    let errors_count = 0;
    $.each(required_inputs, function () {
        if (($(this).val()).isEmpty()) {
            errors_count++;
            $(this).addClass('is-invalid').parent().find('.invalid-feedback').text((lang.validation.required).replace(":attribute", ($(this).parent().find('label').text()).replace('*', '')));
        }
    })

    $.each($(formId).find('input[type=email]'), function () {
        if (!($(this).val()).isEmpty() && !ValidateEmail($(this).val())) {
            errors_count++;
            $(this).addClass('is-invalid').parent().find('.invalid-feedback').text((lang.validation.email).replace(":attribute", ($(this).parent().find('label').text()).replace('*', '')));
        }
    })

    if (errors_count) return false;
    return true;
}

ValidateEmail = function (mail) {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) return true;
    return false;
}
uploadImage = function (input) {
    let fileInfo = input.files[0] || false;
    let size_MB = (fileInfo.size / (1024 * 1024)).toFixed(2);
    let id = ($(input).attr('id')).replaceAll('.', '\\.');
    let progressBar = $('.progress_file_' + id).find('.progress-bar');
    let imageShowCase = $('.image_showcase_' + id);
    let hfileInput = $('#input_file_' + id);;
    let uploadPath = $(input).data('path') || false;
    if (!uploadPath || !fileInfo) return false;
    if (!['image/png', 'image/jpeg'].includes(fileInfo.type)) {
        toastr.error((lang.validation.mimes).replace(':values', 'png, jpeg, jpg'));
        return false;
    }

    progressBar.removeClass('bg-danger bg-success').addClass('bg-primary').text("0%").width(0 + "%").attr('aria-valuenow', 0).parent().show();
    let formData = new FormData();
    formData.append('file', fileInfo);
    formData.append('path', uploadPath);
    $.ajax({
        xhr: function () {
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.onprogress = function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100).toFixed(2);
                        if (percentComplete > 99) percentComplete == 99;
                        progressBar.width(percentComplete + "%").attr('aria-valuenow', percentComplete).text(percentComplete + "%");
                        console.log(percentComplete);
                    }
                }
            }
            return xhr;
        },
        method: 'POST',
        url: uploadUrl,
        data: formData,
        dataType: "JSON",
        processData: false,
        contentType: false,
        cache: false,

    }).done(res => {
        progressBar.removeClass('bg-primary').addClass('bg-success').width(100 + "%").attr('aria-valuenow', 100).text("100%");
        setTimeout(() => {
            progressBar.parent().hide();
        }, 500);
        imageShowCase.html(`<img src="${GLOBAL["APP_URL"] + '/storage/' + res.path}">`).show();
        hfileInput.val(res.path);
    }).fail(res => {
        if (res.status == 422) message = res.responseJSON.message;
        else message = res.statusText;
        progressBar.removeClass('bg-primary').addClass('bg-danger').width(100 + "%").attr('aria-valuenow', 100).text(message);
    })
}

openModal = function (modalId) {
    // data-bs-dismiss="modal"
    $(modalId).addClass('show').removeAttr('aria-hidden').attr('aria-modal', "true").show();
    let modalBackdrop = $(`<div class="modal-backdrop fade show"></div>`).appendTo('body');
    $(modalId).find('[data-bs-dismiss=modal]').click(function () {
        $(modalId).removeClass('show').attr('aria-hidden', true).removeAttr('aria-modal').hide();
        modalBackdrop.remove();
    });
}

setupDatePicker = function (params) {
    let futureYear = (new Date().getFullYear()) + 20;
    $("input[type=date]").each(function (i) {
        $(this).attr('type', 'text');
        $(this).datepicker({
            isRTL: GLOBAL["IS_RTL"],
            gotoCurrent: true,
            dateFormat: "yy-mm-dd",
            changeYear: true,
            changeMonth: true,
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            yearRange: "1950:" + futureYear,
            ...params
        });
    });
}

function getUrlVars(blacklistParams = [], defaultParams = {}) {
    var href = decodeURIComponent(window.location.href)
    var vars = [], hash;
    var hashes = (window.location.search) ? href.slice(href.indexOf('?') + 1).split('&') : [];

    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        if (!blacklistParams.includes(hash[0])) {
            vars[hash[0]] = hash[1] || '';
        }
    }
    vars = { ...vars, ...defaultParams };
    return vars;
}

putSelectData = function (data = {}, target) {
    if (data) {
        $(target).html('');
        $.each(data, function (value, text) {
            $(target).append(`<option value="${value}">${text}</option>`)
        });
    }
}

String.prototype.isEmpty = function () {
    return (this.length === 0 || !this.trim());
};
