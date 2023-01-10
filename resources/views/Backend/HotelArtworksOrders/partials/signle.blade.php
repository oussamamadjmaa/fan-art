<div class="order_-item d-flex border-bottom py-2 justify-content-between align-items-center {{$class ?? ''}} px-3" id="order_{{$order->id}}">
    <div class="d-flex align-items-center">
        <div class="checkbox me-3">
            <div class="form-check">
                <input class="form-check-input checkbox___item" name="news[]" type="checkbox" value="{{$order->id}}">
            </div>
        </div>
        <div class="order-info d-flex flex-wrap">
            <div>
                <div class="order-title fs-6 mb-1">
                    <h6 class="mb-0">{{$order->responsible_person}}</h6>
                </div>
                <div class="order_-info">
                    <ul class="d-flex p-0 text-secondary mb-0 flex-wrap" style="list-style: none;gap:12px;font-size:14px;">
                        <li>
                            <i class="me-1 bi bi-person"></i> <span>{{str($order->responsible_person)}}</span>
                        </li>
                        @if ($order->facility_name)
                        <li>
                            <i class="me-1 bi bi-person-badge"></i>إسم المنشأة : <span>{{str($order->facility_name)}}</span>
                        </li>
                        @endif
                        <li>
                            <i class="me-1 bi bi-geo-alt-fill"></i> <span>{{$order->city}}</span>
                        </li>
                        <li>
                            <i class="me-1 bi bi-palette"></i> <span>{{$order->quantity}} لوحة</span>
                        </li>
                        <li>
                            <i class="me-1 bi bi-list"></i> المقاسات : <span>{{$order->sizes}}</span>
                        </li>
                        @if (!empty($order->phone))
                        <li>
                            <i class="me-1 bi bi-telephone"></i> <span><a href="tel:{{$order->phone}}">{{$order->phone}}</a></span>
                        </li>
                        @endif
                        @if (!empty($order->email))
                        <li>
                            <i class="me-1 bi bi-envelope"></i> <span><a href="mailto:{{$order->email}}">{{$order->email}}</a></span>
                        </li>
                        @endif

                    </ul>
                </div>
                <div>
                    <p class="mb-0 fs-6">
                        {{ $order->idea }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="order-actions d-flex flex-wrap align-items-center justify-content-center" style="gap: 10px;">
        <div class="dropdown open">
            <a type="button" class="button py-1" id="orderActionsDropDown{{ $order->id }}" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                    </a>
            <div class="dropdown-menu" aria-labelledby="orderActionsDropDown{{ $order->id }}">
                <button type="button" class="dropdown-item text-danger" href="javascript:;" onclick="_s.onDelete(this, {{$order->id}})"><i class="bi bi-trash"></i> @lang('Delete')</button>
            </div>
        </div>
    </div>
</div>
