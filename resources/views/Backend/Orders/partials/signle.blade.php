<div class="order_-item d-flex border-bottom py-2 justify-content-between align-items-center {{$class ?? ''}} px-3" id="order_{{$order->id}}">
    <div class="d-flex align-items-center">
        <div class="checkbox me-3">
            <div class="form-check">
                <input class="form-check-input checkbox___item" name="news[]" type="checkbox" value="{{$order->id}}">
            </div>
        </div>
        <div class="order-info d-flex flex-wrap">
            <div class="me-3">
                <img src="{{ storage_url($order->orderable->image) }}" alt=" {{$order->orderable->title}}" class="avatar-50">
            </div>
            <div>
                <div class="order-title fs-6 mb-1">
                    <h6 class="mb-0">{{$order->orderable->title}}</h6>
                </div>
                <div class="order_-info">
                    <ul class="d-flex p-0 text-secondary mb-0 flex-wrap" style="list-style: none;gap:12px;font-size:11px;">
                        @if (auth()->id() != $order->user_id)
                        <li>
                            <i class="me-1 bi bi-person"></i> <span>{{str($order->user->name)->limit(30)}}</span>
                        </li>
                        @endif
                        <li>
                            <i class="me-1 bi bi-info-circle-fill"></i> <x-badges.order-status :order="$order" />
                        </li>
                        <li>
                            <i class="me-1 bi bi-cash-stack"></i> <span>{{$order->amount}} @lang(config('app.currency'))</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="order-actions d-flex flex-wrap align-items-center justify-content-center" style="gap: 10px;">
        <div class="show-in-footer me-2">
            <div class="form-check form-switch">
                <div>
                  <select class="form-control toggle_status" id="status" data-id="{{$order?->id}}">
                    <option value="">@lang('Order Status')</option>

                    <option value="confirm" @selected($order?->isConfirmed() && !$order?->isShipped() && !$order?->isDelivered())>@lang('Order Confirmed')</option>
                    <option value="ship" @selected($order?->isShipped() && !$order?->isDelivered())>@lang('Order Shipped Out')</option>
                    <option value="deliver" @selected($order?->isDelivered())>@lang('Order Delivered')</option>
                    <option value="cancel" @selected($order?->isCanceled())>@lang('Cancel')</option>
                    <option value="deny" @selected($order?->isDenied())>@lang('Deny')</option>

                  </select>
                </div>
            </div>
        </div>
        <div>
            <a href="{{ storage_url($order->bank_transfer_receipt) }}" target="popup">صورة تأكيد الدفع</a>
        </div>
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
