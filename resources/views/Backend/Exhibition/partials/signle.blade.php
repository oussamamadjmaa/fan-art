<div class="exhibition_-item d-flex border-bottom py-2 justify-content-between align-items-center {{$class ?? ''}} px-3" id="exhibition_{{$exhibition->id}}">
    <div class="d-flex align-items-center">
        <div class="checkbox me-3">
            <div class="form-check">
                <input class="form-check-input checkbox___item" name="news[]" type="checkbox" value="{{$exhibition->id}}">
            </div>
        </div>
        <div class="exhibition-info d-flex flex-wrap">
            <div>
                <div class="exhibition-title fs-6 mb-1">
                    <h6>{{$exhibition->name}}</h5>
                </div>
                <div class="exhibition_-info">
                    <ul class="d-flex p-0 text-secondary mb-0 flex-wrap" style="list-style: none;gap:12px;font-size:11px;">
                        @if (auth()->id() != $exhibition->user_id)
                        <li>
                            <i class="me-1 bi bi-person"></i> <span>{{str($exhibition->user->name)->limit(30)}}</span>
                        </li>
                        @endif

                        <li>
                            <i class="me-1 far fa-handshake"></i> <span>{{$exhibition->sponsor->name}}</span>
                        </li>
                        <li>
                            <i class="me-1 bi bi-geo-alt"></i> <span>{{__(country($exhibition->country)->getName())}}, {{$exhibition->city}}</span>
                        </li>
                        <li>
                            <i class="me-1 bi bi-clock"></i> <span>{{$exhibition->from_to_date}}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="exhibition-actions d-flex flex-wrap align-items-center justify-content-center" style="gap: 10px;">
        <div class="dropdown open">
            <a type="button" class="button py-1" id="exhibitionActionsDropDown{{ $exhibition->id }}" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                    </a>
            <div class="dropdown-menu" aria-labelledby="exhibitionActionsDropDown{{ $exhibition->id }}">
                <button type="button" class="dropdown-item text-primary" href="javascript:;" onclick="_s.openCreateForm(this, {{$exhibition->id}})"><i class="bi bi-pencil-square"></i> @lang('Edit')</button>
                <button type="button" class="dropdown-item text-danger" href="javascript:;" onclick="_s.onDelete(this, {{$exhibition->id}})"><i class="bi bi-trash"></i> @lang('Delete')</button>
            </div>
        </div>
    </div>
</div>
