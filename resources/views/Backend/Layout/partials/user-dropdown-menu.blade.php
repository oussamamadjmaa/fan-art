@php
    $id = isset($is_phone) ? "userDropdownMenuPhone" : "userDropdownMenu";
@endphp
<div class="user-dropdown-menu">
    <div class="dropdown open">
        <a  @class(['btn', 'dropdown-toggle' => !isset($is_phone)]) type="button" id="{{$id}}" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                    <img src="{{ $auth_->avatar_url ?? '' }}" alt="{{ $auth_->image ?? '' }}" class="avatar-30 user_avatar_img @if (!isset($is_phone)) me-1 @endif">
                    @if (!isset($is_phone))
                        <span>{{ $auth_->name ?? '' }}</span>
                    @endif
                </a>
        <div class="dropdown-menu" aria-labelledby="{{$id}}">
            <a class="dropdown-item" href="{{route('backend.account.profile')}}"><i class="bi bi-person me-2"></i> @lang('Profile')</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="javascript:;" onclick="document.getElementById('logoutForm').submit();">
                <i class="bi bi-power me-2"></i>  @lang('Logout')
            </a>
        </div>
    </div>
</div>
