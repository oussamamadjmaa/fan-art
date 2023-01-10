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

$(document).on('keypress', ".number-input", (e) => window._s.validate_input_number(e));

_s.handleFailure = function (fail) {
    let jsonRes = fail.responseJSON;
    $(_s.dataFormId).find('.is-invalid').removeClass('is-invalid');
    if (jsonRes) {
        if (fail.status == 422) {
            if (jsonRes.errors) {
                $.each(jsonRes.errors, function (input, error) {
                    input = input.replaceAll('.', '__');
                    $(_s.dataFormId).find("*[name=" + input + "], #"+input).addClass('is-invalid').parent().find('.invalid-feedback').text(error);
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

_s.setRequiredInputsStar = function () {
    let required_inputs = $(document).find('*[required]');
    $.each(required_inputs, function () {
        $(this).parent().find('label').append(`<span class="text-danger">*</span>`);
    })
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
_s.uploadImage = function (input) {
    let fileInfo = input.files[0] || false;
    let size_MB = (fileInfo.size / (1024 * 1024)).toFixed(2);
    let id = ($(input).attr('id')).replaceAll('.', '\\.');
    let progressBar = $('.progress_file_' + id).find('.progress-bar');
    let imageShowCase = $('.image_showcase_' + id);
    let hfileInput = $('#input_file_' + id);;
    let uploadPath = $(input).data('path') || false;
    if (!uploadPath || !fileInfo) return false;
    if (!['image/png', 'image/jpeg', 'image/webp'].includes(fileInfo.type)) {
        toastr.error((lang.validation.mimes).replace(':values', 'png, jpeg, jpg, webp'));
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
        if (res.status == 422) var message = res.responseJSON.message;
        else var message = res.statusText;
        progressBar.removeClass('bg-primary').addClass('bg-danger').width(100 + "%").attr('aria-valuenow', 100).text(message);
    })
}

_s.openModal = function (modalId) {
    // data-bs-dismiss="modal"
    $(modalId).addClass('show').removeAttr('aria-hidden').attr('aria-modal', "true").show();
    let modalBackdrop = $(`<div class="modal-backdrop fade show"></div>`).appendTo('body');
    $(modalId).find('[data-bs-dismiss=modal]').click(function () {
        $(modalId).removeClass('show').attr('aria-hidden', true).removeAttr('aria-modal').hide();
        modalBackdrop.remove();
    });
}

_s.setupDatePicker = function (params) {
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

_s.getUrlVars = function(blacklistParams = [], defaultParams = {}) {
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

_s.putSelectData = function (data = {}, target) {
    if (data) {
        $(target).html('');
        $.each(data, function (value, text) {
            $(target).append(`<option value="${value}">${text}</option>`)
        });
    }
}

_s.makeTinymce = function(selector){
    tinymce.remove(selector);
    tinymce.init({
        selector: selector,
        plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
        imagetools_cors_hosts: ['picsum.photos'],
        menubar: 'file edit view insert format tools table help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        toolbar_sticky: false,
        autosave_ask_before_unload: true,
        autosave_interval: "30s",
        autosave_prefix: "{path}{query}-{id}-",
        autosave_restore_when_empty: false,
        autosave_retention: "2m",
        image_advtab: true,
    });
}

String.prototype.isEmpty = function () {
    return (this.length === 0 || !this.trim());
};


