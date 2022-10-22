<div class="product_-item d-flex border-bottom py-2 justify-content-between align-items-center {{$class ?? ''}} px-3" id="product_{{$product->id}}">
    <div class="d-flex align-items-center">
        <div class="checkbox me-3">
            <div class="form-check">
                <input class="form-check-input checkbox___item" name="news[]" type="checkbox" value="{{$product->id}}">
            </div>
        </div>
        <div class="product-info d-flex flex-wrap">
            <div class="me-3">
                <img src="{{ storage_url($product->image) }}" alt=" {{$product->name}}" class="avatar-50">
            </div>
            <div>
                <div class="product-title fs-6 mb-1">
                    <h6>{{$product->name}}</h5>
                </div>
                <div class="product_-info">
                    <ul class="d-flex p-0 text-secondary mb-0 flex-wrap" style="list-style: none;gap:12px;font-size:11px;">
                        @if (auth()->id() != $product->user_id)
                        <li>
                            <i class="me-1 bi bi-person"></i> <span>{{str($product->user->name)->limit(30)}}</span>
                        </li>
                        @endif

                        @if (!empty($product->category))
                        <li>
                            <i class="me-1 bi bi-list"></i> <span>{{$product->category->name}}</span>
                        </li>
                        @endif
                        <li>
                            <i class="me-1 bi bi-cash-stack"></i> <span>{{price_format($product->price)}} @lang(config('app.currency'))</span>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="product-actions d-flex flex-wrap align-items-center justify-content-center" style="gap: 10px;">
        <div>
            <a type="button" class="button py-1" href="{{ route('backend.products.messages', $product->id) }}" >
                    @lang('New messages') ({{$product?->messages_count ?? 0}})
                </a>
        </div>
        <div class="dropdown open">
            <a type="button" class="button py-1" id="productActionsDropDown{{ $product->id }}" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                    </a>
            <div class="dropdown-menu" aria-labelledby="productActionsDropDown{{ $product->id }}">
                <button type="button" class="dropdown-item text-primary" href="javascript:;" onclick="_s.openCreateForm(this, {{$product->id}})"><i class="bi bi-pencil-square"></i> @lang('Edit')</button>
                <button type="button" class="dropdown-item text-danger" href="javascript:;" onclick="_s.onDelete(this, {{$product->id}})"><i class="bi bi-trash"></i> @lang('Delete')</button>
            </div>
        </div>
    </div>
</div>
