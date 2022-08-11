<div class="artwork_-item d-flex border-bottom py-2 justify-content-between align-items-center {{$class ?? ''}} px-3" id="artwork_{{$artwork->id}}">
    <div class="d-flex align-items-center">
        <div class="checkbox me-3">
            <div class="form-check">
                <input class="form-check-input checkbox___item" name="news[]" type="checkbox" value="{{$artwork->id}}">
            </div>
        </div>
        <div class="artwork-info d-flex flex-wrap">
            <div class="me-3">
                <img src="{{ storage_url($artwork->image) }}" alt=" {{$artwork->title}}" class="avatar-50">
            </div>
            <div>
                <div class="artwork-title fs-6 mb-1">
                    <h5 class="mb-0">{{$artwork->title}}</h5>
                    <small>{{ str($artwork->description)->limit(50) }}</small>
                </div>
                <div class="artwork_-info">
                    <ul class="d-flex p-0 text-secondary mb-0 flex-wrap" style="list-style: none;gap:12px;font-size:11px;">
                        <li>
                            <i class="me-1 bi bi-info-circle-fill"></i> <span>{{$artwork->status_text}}</span>
                        </li>
                        <li>
                            <i class="me-1 bi bi-cash-stack"></i> <span>{{price_format($artwork->price)}} @lang(config('app.currency'))</span>
                        </li>
                        <li>
                            <i class="me-1 bi bi-geo-alt-fill"></i> <span>{{ str($artwork->location)->limit(50) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="artwork-actions d-flex flex-wrap align-items-center justify-content-center" style="gap: 10px;">
        <div class="show-in-footer me-2">
            <div class="form-check form-switch">
                <div>
                  <select class="form-control toggle_status" id="status" data-id="{{$artwork?->id}}">
                    <option value="1" @selected($artwork?->status === App\Models\Artwork::READY)>@lang('Ready for delivery')</option>
                    <option value="0" @selected($artwork?->status === App\Models\Artwork::NOT_READY)>@lang('In preparation')</option>
                    <option value="2" @selected($artwork?->status === App\Models\Artwork::SOLD)>@lang('Sold')</option>
                  </select>
                </div>
            </div>
        </div>
        <div class="dropdown open">
            <a type="button" class="button py-1" id="artworkActionsDropDown{{ $artwork->id }}" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                    </a>
            <div class="dropdown-menu" aria-labelledby="artworkActionsDropDown{{ $artwork->id }}">
                <button type="button" class="dropdown-item text-primary" href="javascript:;" onclick="_s.openCreateForm(this, {{$artwork->id}})"><i class="bi bi-pencil-square"></i> @lang('Edit')</button>
                <button type="button" class="dropdown-item text-danger" href="javascript:;" onclick="_s.onDelete(this, {{$artwork->id}})"><i class="bi bi-trash"></i> @lang('Delete')</button>
            </div>
        </div>
    </div>
</div>
