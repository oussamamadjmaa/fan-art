@forelse ($messages as $message)
    @php
        $name_ = $message->sender_id ? ($message->sender?->name ?: '') : "{$message->data->first_name} {$message->data->last_name}";
        $phone_ = $message->sender_id ? ($message->sender?->phone ?: '') : $message->data?->phone;
        $email_ = $message->sender_id ? ($message->sender?->email ?: '') : $message->data?->email;
    @endphp
    <div class="product-message-item p-2 @if(!$message->seen_at) bg-light @endif border-bottom d-block text-dark"
        href="#">
        <div class="d-flex">
            <div class="product-sender-image me-2">
                <div class="avatar-50">
                    <img src="{{ $message->sender?->avatar_url ?: storage_url($message->messageable->image) }}"
                        alt="{{ $message->sender?->name ?: $message->messageable->name }}" class="avatar-50">
                </div>
            </div>
            <div class="product-message-info">
                <h6 class="product-message-from mb-0">{{ $name_ }}</h6>
                @if (isset($show_product_name))
                <small class="text-secondary d-block">{{$message->messageable->name}}</small>
                @endif
                <small class="product-message-shortbody mb-0">{!! nl2br(e($message->body)) !!}</small>
                <div class="product-message-contact-info mt-1">
                    <ul class="d-flex p-0 text-secondary mb-0 flex-wrap"
                        style="list-style: none;gap:12px;font-size:13px;">
                        <li>
                            <i class="me-1 fa fa-clock"></i> <span>{{ $message->created_at->diffForHumans() }}</span>
                        </li>
                        @if ($phone_)
                            <li>
                                <i class="me-1 fa fa-phone"></i> <span><a
                                        href="tel:{{ $phone_ }}">{{ $phone_ }}</a></span>
                            </li>
                        @endif
                        @if ($email_)
                            <li>
                                <i class="me-1 fa fa-envelope"></i> <span><a
                                        href="mailto:{{ $email_ }}">{{ $email_ }}</a></span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@empty
<p class="col-12 text-center py-3 my-0">
    ???? ???????? ???? ??????????
</p>
@endforelse
