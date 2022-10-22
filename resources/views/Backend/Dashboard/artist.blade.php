<div class="row">
    <div class="col-lg-7">
        <div class="row">
            <div class="col-sm-6 mb-3">
                <div class="dashboard-stat-box p-3">
                    <h5>@lang('Artworks')</h5>
                    <h3>{{auth()->user()->artworks()->count()}}</h3>
                    <p><small>@lang('Total number of your artworks')</small></p>
                </div>
            </div>
            <div class="col-sm-6 mb-3">
                <div class="dashboard-stat-box p-3">
                    <h5>@lang('Blog')</h5>
                    <h3>{{auth()->user()->news()->count()}}</h3>
                    <p><small>@lang('Total number of your blogs')</small></p>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="p-3 bg-white">
                    <h3>@lang('Visitors stats')</h3>
                    <form action="" id="durationForm">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-8">
                                <div class="mb-0">
                                    <select class="form-control" name="duration" id="visits_duration">
                                      @foreach (['Today', 'Last 30 days', 'Last year'] as $duration_item)
                                         <option value="{{$duration_item}}" @selected($duration_item == request()->get('duration', 'Last 30 days') || ($duration_item == 'Last 30 days' && !in_array(request()->get('duration'), ['Today', 'Last 30 days', 'Last year'])))>@lang($duration_item)</option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row mt-3">
                        @foreach ($visit_stats as $visit_stat_title => $visit_stat_count)
                        <div class="col-sm-6 mb-3">
                            <div class="dashboard-stat-box p-3">
                                <h4>@lang(ucfirst($visit_stat_title))</h4>
                                <h4>{{$visit_stat_count}} <small>@lang('visits')</small></h4>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body p-0">
                        <h5 class="border-bottom p-2">@lang('Latest artworks messages')</h5>
                        <div id="latest_artworks_messages"></div>
                    </div>
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
