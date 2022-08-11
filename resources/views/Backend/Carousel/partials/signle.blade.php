<div class="carousel_-item d-flex border-bottom py-2 justify-content-between align-items-center {{$class ?? ''}} px-3" id="carousel_{{$carousel->id}}">
    <div class="d-flex align-items-center">
        <div class="checkbox me-3">
            <div class="form-check">
                <input class="form-check-input checkbox___item" name="news[]" type="checkbox" value="{{$carousel->id}}">
            </div>
        </div>
        <div class="carousel-info d-flex flex-wrap">
            <div class="me-3">
                <img src="{{ storage_url($carousel->background_image) }}" alt=" {{$carousel->text}}" class="avatar-50">
            </div>
            <div>
                <div class="carousel-title fs-6 mb-1">
                    {{$carousel->name}}
                </div>
                <div class="carousel_-info">
                    <ul class="d-flex p-0 text-secondary mb-0 flex-wrap" style="list-style: none;gap:7px;font-size:11px;">
                        <li>
                            <i class="bi bi-list-ol"></i> <span>{{$carousel->order}}</span>
                        </li>
                        <li>
                            <i class="bi bi-bi bi-blockquote-left"></i> <span>{{$carousel->text}}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="carousel-actions d-flex flex-wrap align-items-center justify-content-center" style="gap: 10px;">
        <div class="show-in-footer me-2">
            <div class="form-check form-switch">
                <input class="form-check-input toggle_status" type="checkbox" id="status" data-id="{{ $carousel->id }}" @checked($carousel->status) data-bs-toggle="tooltip" data-bs-placement="right" title="@lang('Activate')" style="transform: scale(1.65);">
            </div>
        </div>
        <div class="dropdown open">
            <a type="button" class="button py-1" id="carouselActionsDropDown{{ $carousel->id }}" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                    </a>
            <div class="dropdown-menu" aria-labelledby="carouselActionsDropDown{{ $carousel->id }}">
                <button type="button" class="dropdown-item text-primary" href="javascript:;" onclick="_s.openCreateForm(this, {{$carousel->id}})"><i class="bi bi-pencil-square"></i> @lang('Edit')</button>
                <button type="button" class="dropdown-item text-danger" href="javascript:;" onclick="_s.onDelete(this, {{$carousel->id}})"><i class="bi bi-trash"></i> @lang('Delete')</button>
            </div>
        </div>
    </div>
</div>
