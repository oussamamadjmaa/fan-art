<div class="sponsor_-item d-flex border-bottom py-2 justify-content-between align-items-center {{$class ?? ''}} px-3" id="sponsor_{{$sponsor->id}}">
    <div class="d-flex align-items-center">
        <div class="checkbox me-3">
            <div class="form-check">
                <input class="form-check-input checkbox___item" name="news[]" type="checkbox" value="{{$sponsor->id}}">
            </div>
        </div>
        <div class="sponsor-info d-flex flex-wrap">
            <div class="me-3">
                <img src="{{ storage_url($sponsor->logo) }}" alt=" {{$sponsor->title}}" class="avatar-50">
            </div>
            <div>
                <div class="sponsor-title fs-6 mb-1">
                    <h6>{{$sponsor->name}}</h5>
                </div>
                <div class="sponsor_-info">
                    <ul class="d-flex p-0 text-secondary mb-0 flex-wrap" style="list-style: none;gap:12px;font-size:11px;">
                        @if (auth()->id() != $sponsor->user_id)
                        <li>
                            <i class="me-1 bi bi-person"></i> <span>{{str($sponsor->user->name)->limit(30)}}</span>
                        </li>
                        @endif

                        @if (!empty($sponsor->phone))
                        <li>
                            <i class="me-1 bi bi-telephone"></i> <span><a href="tel:{{$sponsor->phone}}">{{$sponsor->phone}}</a></span>
                        </li>
                        @endif
                        @if (!empty($sponsor->email))
                        <li>
                            <i class="me-1 bi bi-envelope"></i> <span><a href="mailto:{{$sponsor->email}}">{{$sponsor->email}}</a></span>
                        </li>
                        @endif
                        @if (!empty($sponsor->address))
                        <li>
                            <i class="me-1 bi bi-geo-alt"></i> <span>{{str($sponsor->address)->limit(40)}}</span>
                        </li>
                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="sponsor-actions d-flex flex-wrap align-items-center justify-content-center" style="gap: 10px;">
        <div class="dropdown open">
            <a type="button" class="button py-1" id="sponsorActionsDropDown{{ $sponsor->id }}" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                    </a>
            <div class="dropdown-menu" aria-labelledby="sponsorActionsDropDown{{ $sponsor->id }}">
                <button type="button" class="dropdown-item text-primary" href="javascript:;" onclick="_s.openCreateForm(this, {{$sponsor->id}})"><i class="bi bi-pencil-square"></i> @lang('Edit')</button>
                <button type="button" class="dropdown-item text-danger" href="javascript:;" onclick="_s.onDelete(this, {{$sponsor->id}})"><i class="bi bi-trash"></i> @lang('Delete')</button>
            </div>
        </div>
    </div>
</div>
