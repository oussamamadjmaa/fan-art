$(function(){
    if(!(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))) {
        $("#artwork_img_01").ezPlus({
            scrollZoom: true,
            tint: true,
            tintColour: '#000', tintOpacity: 0.5
        });
    }

    $(document).on('submit', '#artwork_message_form, #artwork_order_form', function(e) {
        e.preventDefault();
        if(!_s.validateForm(this)) return false;

        let formData = new FormData(this);
        let url = $(this).data('action');
        $(this).find('button').prop('disabled', true);
        $.ajax({
            method:"POST",
            data:formData,
            url:url,
            dataType:"JSON",
            contentType:false,
            cache:false,
            processData:false
        }).always((data) => {
            $(this).find('button').prop('disabled', false);
        }).done((data) => {
            $(this).trigger('reset');
            $("#artworkContactModal").modal('hide');
            window.Swal.fire({
                icon: 'success',
                text: data.message,
                confirmButtonText: GLOBAL['LANG'] == 'ar' ? 'إغلاق' : 'Close',
            })
        }).fail((fail) => {
            _s.handleFailure(fail, this);
        });
    })
})
