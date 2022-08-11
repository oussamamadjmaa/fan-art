<div class="page-item d-flex border-bottom py-2 justify-content-between align-items-center {{$class ?? ''}} px-3" id="page_{{$page->id}}">
    <div class="d-flex align-items-center">
        <div class="checkbox me-3">
            <div class="form-check">
                <input class="form-check-input checkbox___item" name="pages[]" type="checkbox" value="{{$page->id}}">
            </div>
        </div>
        <div class="page-info">
            <div class="page-title fs-6">
                <a href="{{ $page->link }}" target="_blank">{{$page->title}}</a>
            </div>
        </div>
    </div>
    <div class="page-actions d-flex flex-wrap align-items-center justify-content-center" style="gap: 10px;">
        <div class="show-in-footer me-2">
            <div class="form-check form-switch">
                <input class="form-check-input toggle_status" type="checkbox" id="status" data-id="{{ $page->id }}" @checked($page->status) data-bs-toggle="tooltip" data-bs-placement="right" title="@lang('Show in footer')" style="transform: scale(1.65);">
            </div>
        </div>
        <div class="dropdown open">
            <a type="button" class="button py-1" id="pageActionsDropDown{{ $page->id }}" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                    </a>
            <div class="dropdown-menu" aria-labelledby="pageActionsDropDown{{ $page->id }}">
                <a type="button" class="dropdown-item text-primary" href="{{$page->link}}" target="_blank"><i class="bi bi-link"></i> @lang('Open Page Link')</a>
                <button type="button" class="dropdown-item text-primary" href="javascript:;" onclick="_s.openCreateForm(this, {{$page->id}})"><i class="bi bi-pencil-square"></i> @lang('Edit')</button>
                <button type="button" class="dropdown-item text-danger" href="javascript:;" onclick="_s.onDelete(this, {{$page->id}})"><i class="bi bi-trash"></i> @lang('Delete')</button>
            </div>
        </div>
    </div>
</div>
