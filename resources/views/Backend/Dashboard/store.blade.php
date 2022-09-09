<div class="row">
    <div class="col-lg-7">
        <div class="row">
            <div class="col-sm-6 mb-3">
                <div class="dashboard-stat-box p-3">
                    <h5>@lang('Products')</h5>
                    <h3>{{auth()->user()->products()->count()}}</h3>
                    <p><small>@lang('Total number of your products')</small></p>
                </div>
            </div>
            <div class="col-sm-6 mb-3">
                <div class="dashboard-stat-box p-3">
                    <h5>@lang('Categories')</h5>
                    <h3>{{auth()->user()->categories()->count()}}</h3>
                    <p><small>@lang('Total number of your categories')</small></p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5 mb-3">
        <div class="card">
            <div class="card-body p-0">
                <h5 class="border-bottom p-2">
                    @lang('Latest notifications')
                    <small>
                        <span class="notificationsCount" data-count="0" style="top: 5px;">
                            (<span class="count">0</span>
                            <span>@lang('Unseen')</span>)
                        </span>
                    </small>
                </h5>
                <div id="latest_notifications" class="pushNotifications__"></div>
                <div class="p-2 d-grid border-top">
                    <a class="font-size-14 text-center" href="{{route('backend.notifications.index')}}">  <i class="mdi mdi-bell"></i> عرض الكل</a>
                </div>
            </div>
        </div>
    </div>

</div>
