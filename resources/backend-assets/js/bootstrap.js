import $ from 'jquery';

window.$ = window.jQuery = $;

$.ajaxSetup({
    headers:
        { 'X-CSRF-TOKEN': GLOBAL["CSRF_TOKEN"] }
});


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;


window.Echo = new Echo({
    broadcaster: 'pusher',
    key: GLOBAL.PUSHER_APP_KEY,
    wsHost: GLOBAL.PUSHER_HOST || `ws-${GLOBAL.PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: GLOBAL.PUSHER_PORT || 80,
    wssPort: GLOBAL.PUSHER_PORT || 443,
    forceTLS: (GLOBAL.PUSHER_SCHEME || 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

//Notifications
let pushNotification = ".pushNotifications__";
let emptyNotifications = false;
let elNotificationSound = document.createElement('audio');
elNotificationSound.src = GLOBAL.APP_URL+"/assets/sounds/trn.mp3";

function prependNotification(notification){
    if(emptyNotifications) $(pushNotification).html('');
    $(pushNotification).prepend(`<a href="${GLOBAL.APP_URL+"/panel/notifications/"+notification.id}" class="text-reset notification-item">
    <div class="d-flex pt-3 border-bottom ${!notification.seen ? 'bg-light' : ''}" style="border-color: #bababa6b!important;">
        <div class="me-3">
            <span class="avatar-40">
                <img src="${notification.from_user.avatar_url}" alt="${notification.from_user.name}" class="avatar-40">
            </span>
        </div>
        <div class="flex-1">
            <h6 class="mb-1">${notification.title}</h6>
            <div class="font-size-12 text-muted">
                <small class="d-block text-dark">${notification.description}</small>
                <small class="">${notification.created_at_for_humans}</small>
            </div>
        </div>
    </div>
    </a>`);
}

if (GLOBAL['userId']) {
    window.Echo.private(`notifications.${GLOBAL.userId}`)
        .listen('.notification.new', (e) => {
            elNotificationSound.play().catch(function(error){});
           // toastr.info(GLOBAL.LANG == "ar" ? 'لديك إشعار جديد' : "You have new notification");
            $(".notificationsCount").attr('data-count', e.stats.notifications_count).find('.count').text(e.stats.notifications_count);
            prependNotification(e.notification);
        });
}

$.ajax({
    method: "GET",
    url: GLOBAL.APP_URL+"/panel/notifications/stats",
    dataType: "JSON"
}).done((res) => {
    $(".notificationsCount").attr('data-count', res.unread_count).find('.count').text(res.unread_count)
    let notifications = res.notifications;

    if (notifications.length <= 0) {
        emptyNotifications = true;
        $(pushNotification).html(`<div class="text-center py-3">لا يوجد أي إشعارات</div>`);
    } else {
        notifications.forEach(function (e) {
           prependNotification(e);
        });
    }
})

//Change avatar
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
                    $(cr.target+',img.user_avatar_img').attr('src', res.avatar_url);
                    toastr.success(GLOBAL.LANG == "ar" ? 'تم تغيير صورة الملف الشخصي بنجاح' : "Your avatar has been changed successfully")
                    cr.modal.modal('hide');
                }).fail((res) => {
                    btn.prop('disabled', false);
                    toastr.error(res.responseJSON.message)
                });
            };
        });
    });
    return modal;
}

$(function(){
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
            alert((lang.validation.mimes).replace(':values', 'png, jpeg, jpg'))
            return false;
        }
        inputImagePlaceholder($(this)[0].files[0], target);
    });
})
