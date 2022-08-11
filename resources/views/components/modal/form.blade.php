@props([
    'title' => 'Modal Title',
    'onclick' => '_s.submitCreate(this)'
])
<div class="modal fade" id="formModalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleformModalId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$title}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:;" id="dataFormId">
                    {{$slot}}
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                <button type="button" class="btn btn-primary" onclick="{{ $onclick }}">
                    <span>@lang('Save')</span>
                </button>
            </div>
        </div>
    </div>
    <script>
        _s.setRequiredInputsStar();
        $("#formModalId").modal({backdrop: 'static', keyboard: false});
        $('#formModalId').find('select').select2({
            dropdownParent: $('#formModalId').find('.modal-body').first()
        });
        _s.setupDatePicker({container: '#formModalId .modal-body'});
    </script>
</div>

