import _ from 'lodash';
window._ = _;

//import 'bootstrap';

import $ from 'jquery';
window.$ = window.jQuery = $;

import Swal from 'sweetalert2';
window.Swal = Swal;

$.ajaxSetup({
    headers:
        { 'X-CSRF-TOKEN': GLOBAL["CSRF_TOKEN"] }
});

$(window).scroll(function(e) {
    if($(document).scrollTop() > 150) $("#goToTop").fadeIn()
    else  $("#goToTop").fadeOut()
});

$(document).on('click', "#goToTop", function() {
    window.scrollTo({top: 0, behavior: 'smooth'});
})
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });

var cr = {};
cr.modal, cr.image, cr.cropper;

function makeCrModal() {
    var modal = $(`<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="w-100">
                                            <img id="avatarImgCrp" style="height:100%;width:100%;">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">${GLOBAL['LANG'] == "ar" ? 'إغلاق' : 'Close'}</button>
                                        <button type="button" class="btn btn-primary" id="saveAvatar">${GLOBAL['LANG'] == "ar" ? 'حفظ' : 'Save'}</button>
                                    </div>
                                </div>
                            </div>
                        </div>`).appendTo('body');
    modal.modal({backdrop: 'static', keyboard: false});
    modal.on('shown.bs.modal', function () {
        cr.cropper = new Cropper(cr.image, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '.preview',
            // cropBoxResizable:false,
            cropBoxResizable: false,
            minCropBoxWidth: 512,
            minCropBoxHeight: 512,
            maxCropBoxWidth: 512,
            maxCropBoxHeight: 512,
        })
    }).on('hidden.bs.modal', function () {
        modal.remove();
        cr.cropper.destroy();
        cr.cropper = '';
        $("input#avatar").val('');
    });

    modal.find("#saveAvatar").click(function () {
        var btn = $(this);
        $(this).prop('disabled', true);
        cr.canvas = cr.cropper.getCroppedCanvas({
            width: 512,
            height: 512,
        });

        cr.canvas.toBlob(function (blob) {
            cr.url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                var base64data = reader.result;
                var formData = new FormData();
                formData.append('avatar', base64data);
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: GLOBAL['APP_URL'] + "/upload-avatar",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false
                }).done((res) => {
                    $(cr.target).attr('src', res.avatar_url);
                    cr.modal.modal('hide');
                }).fail((res) => {
                    btn.prop('disabled', false);
                    Swal.fire({text: res.responseJSON.message, icon:"error"})
                });
            };
        });
    });
    return modal;
}

$(function () {
    $('.app-preloader').fadeOut(700, function(){
        $(this).remove();
    });
    function inputImagePlaceholder(file, target) {
        cr.target = target;
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function () {
            cr.modal = makeCrModal();
            cr.image = cr.modal.find("#avatarImgCrp")[0];
            cr.image.src = reader.result;
            cr.modal.modal('show');
        };
        reader.onerror = function (error) {
            console.log('Error: ', error);
        };
    }

    $(document).on('change', '[image-placeholder]', function () {
        let target = $(this).attr('image-placeholder');
        let fileInfo = $(this)[0].files[0] || false;
        let size_MB = (fileInfo.size / (1024 * 1024)).toFixed(2);
        if (!fileInfo) return false;
        // if (size_MB > 3) {
        //     alert(GLOBAL['LANG'] == "ar" ? "يجب أن لا يتعدى حجم الصورة 2 ميغابايت" : "The image size must be less then or equal 2MB")
        //     return false;
        // }
        if (!['image/png', 'image/jpeg', 'image/webp'].includes(fileInfo.type)) {
            alert((lang.validation.mimes).replace(':values', 'png, jpeg, jpg, webp'))
            return false;
        }
        inputImagePlaceholder($(this)[0].files[0], target);
    });

    $(document).on('click', '.show-password', function () {
        if ($(this).hasClass('active')) $(this).parent().find('input').attr('type', 'password');
        else $(this).parent().find('input').attr('type', 'text');
        $(this).toggleClass('active');
    });
    $(document).on('submit', '.auth-form form', function () {
        $('.auth-btn').prop('disabled', true);
    });

    $(document).on('change input keyup', '.is-invalid', function(){
        $(this).removeClass('is-invalid');
    });

    //Sidebar toggler
    var sidebarActive = false;
    let sidebarEl = document.querySelector('._navbar#navbar');
    let phoneBarsEl = document.querySelector('._navbar__phone-bars');
    phoneBarsEl.onclick = function(){ toggleSidebar() };

    var toggleSidebar = function () {
        sidebarActive = !sidebarActive;
        sidebarEl.classList.toggle('active');
        if (sidebarEl.classList.contains('active')) {
            phoneBarsEl.classList.add('active');
            if (!document.querySelector('.sidebar-backdrop')) {
                createSidebarBackdrop();
            }
        } else {
            phoneBarsEl.classList.remove('active');
            let backdrop = document.querySelector('.sidebar-backdrop');
            if (backdrop) backdrop.remove();
        }
    }
    var createSidebarBackdrop = function () {
        let backdrop = document.createElement('div');
        backdrop.classList.add('sidebar-backdrop');
        backdrop.onclick = function () {
            toggleSidebar();
        };
        document.querySelector('body').appendChild(backdrop);
    }
});
