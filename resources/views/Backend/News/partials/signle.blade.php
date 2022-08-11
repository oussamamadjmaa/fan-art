<div class="singleNews_-item d-flex border-bottom py-2 justify-content-between align-items-center {{$class ?? ''}} px-3" id="singleNews_{{$singleNews->id}}">
    <div class="d-flex align-items-center">
        <div class="checkbox me-3">
            <div class="form-check">
                <input class="form-check-input checkbox___item" name="news[]" type="checkbox" value="{{$singleNews->id}}">
            </div>
        </div>
        <div class="singleNews_-info d-flex flex-wrap">
            <div class="me-3">
                <img src="{{ storage_url($singleNews->image) }}" alt=" {{$singleNews->title}}" class="avatar-50">
            </div>
            <div>
                <div class="singleNews_-title fs-6 mb-1">
                    {{$singleNews->title}}
                </div>
                <div class="carousel_-info">
                    <ul class="d-flex p-0 text-secondary mb-0 flex-wrap" style="list-style: none;gap:7px;font-size:11px;">
                        @role('admin')
                        <li>
                            <i class="bi bi-person-circle"></i> <span>{{$singleNews->user->fullname}}</span>
                        </li>
                        @endrole
                        <li>
                            <i class="bi bi-clock"></i> <span>{{$singleNews->created_at->diffForHumans()}}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="singleNews_-actions d-flex flex-wrap align-items-center justify-content-center" style="gap: 10px;">
        <div class="show-in-footer me-2">
            <div class="form-check form-switch">
                <input class="form-check-input toggle_status" type="checkbox" id="status" data-id="{{ $singleNews->id }}" @checked($singleNews->status) data-bs-toggle="tooltip" data-bs-placement="right" title="@lang('Publish')" style="transform: scale(1.65);">
            </div>
        </div>
        <div class="dropdown open">
            <a type="button" class="button py-1" id="singleNewsActionsDropDown{{ $singleNews->id }}" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                    </a>
            <div class="dropdown-menu" aria-labelledby="singleNewsActionsDropDown{{ $singleNews->id }}">
                <button type="button" class="dropdown-item text-primary" href="javascript:;" onclick="_s.openCreateForm(this, {{$singleNews->id}})"><i class="bi bi-pencil-square"></i> @lang('Edit')</button>
                <button type="button" class="dropdown-item text-danger" href="javascript:;" onclick="_s.onDelete(this, {{$singleNews->id}})"><i class="bi bi-trash"></i> @lang('Delete')</button>
            </div>
        </div>
    </div>
</div>
