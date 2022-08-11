let url = window.location;
let cleanUrl = url.origin + url.pathname;
let getCreateModalUrl = cleanUrl+"/create";
let getEditModalUrl = cleanUrl+"/editId/edit";

//Form Vars
let formModalId = "#formModalId";
_s.dataFormId = "#dataFormId";
_s.openCreateForm = function(btn, id = false){
    $(btn).prop('disabled', true).find('i').removeClass('fa-plus').addClass('fa-spinner fa-spin');
    let actionUrl = id == false ? getCreateModalUrl : getEditModalUrl.replace('editId', id);
    $.get(actionUrl)
    .always(res => {
        $(btn).prop('disabled', false).find('i').removeClass('fa-spinner fa-spin').addClass('fa-plus');
    })
    .done(res => {
        window.$(formModalId).modal('hide').remove();
        $("body").append(res.form);
        window.$(formModalId).modal('show');
    }).fail(fail => {
        _s.handleFailure(fail);
    });
}

_s.submitCreate = function(btn){
    tinyMCE.triggerSave();
    if(!_s.validateForm(_s.dataFormId)) return false;

    $(btn).prop('disabled', true).find('span').hide().parent().find('i').remove();
    $(btn).append(`<i class="fa fa-spinner fa-spin"></i>`);

    let modelId = $(_s.dataFormId).find("input[name=model_id]").val() || false;
    let actionUrl = modelId ? cleanUrl+"/"+modelId : cleanUrl;

    $.ajax({
        method:"POST",
        url:actionUrl,
        data:$(_s.dataFormId).serialize(),
        dataType:"JSON"
    })
    .always(res => {
        $(btn).prop('disabled', false).find('span').show().parent().find('i').remove();
    })
    .done(res => {
        toastr.success(res.message || 'OK');
        $(formModalId).modal('hide').remove();

        if(res.new_content){
            $(res.new_content.target).after(res.new_content.content).remove();
        }
        if(res.prepend){
            let content_ = $(res.prepend.content);
            if(!$("#"+content_.attr('id')).length){
                $(res.prepend.target).prepend(res.prepend.content).find('.no-data').remove();
            }else{
                $("#"+content_.attr('id')).after(res.prepend.content).remove();
            }
        }
    }).fail(fail => {
        _s.handleFailure(fail);
    });
}


_s.checkedIdsList = function(){
    let checkedIds = [];
    $('input.checkbox___item[type=checkbox]:checked').each(function(i){
        checkedIds[i] = $(this).val();
    });
    return checkedIds;
}

_s.multipleDelete = function(){
    let ids = _s.checkedIdsList();
    if(!ids.length){
        toastr.warning(lang.js_messages.select_items_first);
        return false;
    }
    if(!confirm(lang.js_messages.multiple_delete_confirmation_message ?? "هل أنت متأكد من عملية الحذف؟")) return false;
    $.ajax({
        method:"POST",
        url: cleanUrl,
        data:{_method:"DELETE", ids:ids},
        dataType:"JSON"
    }).done(res => {
        toastr.success(res.message || 'OK');
        if(res.targets){
            $(res.targets).remove();
        }
    }).fail(fail => {
        _s.handleFailure(fail);
    });
}


_s.onDelete = function(btn, modelId){
    if(!confirm(lang.js_messages.delete_confirmation_message ?? "هل أنت متأكد من عملية الحذف؟")) return false;
    $(btn).prop('disabled', true);
    $.ajax({
        method:"POST",
        url: cleanUrl+"/"+modelId,
        data:{_method:"DELETE"},
        dataType:"JSON"
    }).done(res => {
        toastr.success(res.message || 'OK');
        if(res.target){
            $(res.target).remove();
        }
    }).fail(fail => {
        _s.handleFailure(fail);
    });
}

_s.checkAllItems = function(elem){
    if($(elem).prop('checked')){
        $('input.checkbox___item[type=checkbox]').prop('checked', true).change();
    }else{
        $('input.checkbox___item[type=checkbox]').prop('checked', false).change();
    }
}

$(document).on('change', '.toggle_status', function(){
    var status = $(this).prop('checked') || $(this).val();
    $.post(GLOBAL['PAGE_URL']+'/toggle_status/'+$(this).data('id'), {status: status, _method:'PUT'}, function(res) {
        toastr.success(res.message || 'OK');
    });
})
