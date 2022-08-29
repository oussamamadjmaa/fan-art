@forelse ($notifications as $notification)
    <a class="col-12 px-0 d-block text-dark"
        href="{{ route('backend.notifications.redirect', [$notification->id, 'b' => 'true']) }}">
        <div class="notification-item___ d-flex py-3 px-3 border-bottom {{ !$notification->seen ? 'bg-light' : '' }}"
            style="border-color: #bababa6b!important;">
            <div class="notification-header__">
                <div class="notification-sender-avatar__">
                    <img src="{{ $notification->from_user->avatar_url }}" alt="{{ $notification->from_user->name }} Avatar"
                        width="50" height="50" style="border-radius: 50%;">
                </div>
            </div>
            <div class="notification-body__ ms-2">
                <h5>{{ $notification->title }}</h5>
                <small class="mb-0 d-block">{!! $notification->description !!}</small>
                <small class="text-secondary mb-0">{{ $notification->created_at_for_humans }}</small>
            </div>
        </div>
    </a>
@empty
    <p class="col-12 text-center py-3 my-0">
        لا يوجد أي إشعارات
    </p>
@endforelse
