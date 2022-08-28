$(function(){
    $("#artwork_img_01").ezPlus({
        scrollZoom: true,
        tint: true,
        tintColour: '#000', tintOpacity: 0.5
    });

    $(document).on('submit', '#artwork_message_form', function(e) {
        e.preventDefault();
        if(!_s.validateForm(this)) return false;

        let formData = $(this).serialize();
        let url = $(this).data('action');
        $.ajax({
            method:"POST",
            data:formData,
            url:url,
            dataType:"JSON"
        }).always((data) => {
            $(this).find('#send_btn').prop('disabled', false);
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