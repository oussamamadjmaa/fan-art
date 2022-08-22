<div class="blog_-item d-flex border-bottom py-2 justify-content-between align-items-center {{$class ?? ''}} px-3" id="blog_{{$blog->id}}">
    <div class="d-flex align-items-center">
        <div class="checkbox me-3">
            <div class="form-check">
                <input class="form-check-input checkbox___item" name="blogs[]" type="checkbox" value="{{$blog->id}}">
            </div>
        </div>
        <div class="blog_-info d-flex flex-wrap">
            <div class="me-3">
                <img src="{{ storage_url($blog->image) }}" alt=" {{$blog->title}}" class="avatar-50">
            </div>
            <div>
                <div class="blog_-title fs-6 mb-1">
                    {{$blog->title}}
                </div>
                <div class="carousel_-info">
                    <ul class="d-flex p-0 text-secondary mb-0 flex-wrap" style="list-style: none;gap:7px;font-size:11px;">
                        @if($blog->user_id != auth()->id())
                        <li>
                            <i class="bi bi-person-circle"></i> <span>{{$blog->user->fullname}}</span>
                        </li>
                        @endif
                        <li>
                            <i class="bi bi-clock"></i> <span>{{$blog->created_at->diffForHumans()}}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="blog_-actions d-flex flex-wrap align-items-center justify-content-center" style="gap: 10px;">
        <div class="show-in-footer me-2">
            <div class="form-check form-switch">
                <input class="form-check-input toggle_status" type="checkbox" id="status" data-id="{{ $blog->id }}" @checked($blog->status) data-bs-toggle="tooltip" data-bs-placement="right" title="@lang('Publish')" style="transform: scale(1.65);">
            </div>
        </div>
        <div class="dropdown open">
            <a type="button" class="button py-1" id="blogActionsDropDown{{ $blog->id }}" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                    </a>
            <div class="dropdown-menu" aria-labelledby="blogActionsDropDown{{ $blog->id }}">
                <button type="button" class="dropdown-item text-primary" href="javascript:;" onclick="_s.openCreateForm(this, {{$blog->id}})"><i class="bi bi-pencil-square"></i> @lang('Edit')</button>
                <button type="button" class="dropdown-item text-danger" href="javascript:;" onclick="_s.onDelete(this, {{$blog->id}})"><i class="bi bi-trash"></i> @lang('Delete')</button>
            </div>
        </div>
    </div>
</div>
