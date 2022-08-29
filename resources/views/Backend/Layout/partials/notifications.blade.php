<!-- Notification Dropdown -->
<div class="notifications-dropdown">
    <div class="dropdown">
        <button type="button" title="@lang('Notifications')" class="btn btn-transparent position-relative" data-bs-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
            <i @class(['bi bi-bell', 'text-white' => isset($is_phone)])></i>
            <span class="position-absolute start-0 translate-middle badge rounded-pill bg-danger notificationsCount" data-count="0" style="top: 5px;">
              <span class="count">0</span>
              <span class="visually-hidden">@lang('Unseen Notifications')</span>
            </span>
          </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
            aria-labelledby="page-header-notifications-dropdown">
            <div class="pushNotifications__"></div>
            <div class="p-2 d-grid border-top">
                <a class="font-size-14 text-center" href="{{route('backend.notifications.index')}}">  <i class="mdi mdi-bell"></i> عرض الكل</a>
            </div>
        </div>
    </div>
 </div>
