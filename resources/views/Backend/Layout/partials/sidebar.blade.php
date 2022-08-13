@php
    $sidebar_list = [
        [
            'title' => 'Dashboard',
            'icon' => 'bi bi-house-door',
            'cond' => true,
            'href' => route('backend.dashboard')
        ],[
            'title' => 'Pages Manager',
            'icon' => 'bi bi-file-earmark-richtext',
            'cond' => auth()->user()->hasRole('admin'),
            'href' => route('backend.pages-manager.index')
        ],[
            'title' => 'Carousels',
            'icon' => 'bi bi-image',
            'cond' => auth()->user()->hasRole('admin'),
            'href' => route('backend.carousel.index')
        ],[
            'title' => 'News',
            'icon' => 'bi bi-newspaper',
            'cond' => auth()->user()->hasRole('admin'),
            'href' => route('backend.news.index')
        ],[
            'title' => 'Paintings and artworks',
            'icon' => 'bi bi-palette',
            'cond' => auth()->user()->can('viewAny', App\Models\Artwork::class),
            'href' => route('backend.artworks.index')
        ],[
            'title' => 'Sponsors',
            'icon' => 'far fa-handshake',
            'cond' => auth()->user()->can('viewAny', App\Models\Sponsor::class),
            'href' => route('backend.sponsors.index')
        ],
        [
            'title' => 'Exhibitions',
            'icon' => 'bi bi-calendar-heart',
            'cond' => auth()->user()->can('viewAny', App\Models\Exhibition::class),
            'href' => route('backend.exhibitions.index')
        ],
    ];
    $req_url = request()->url();
@endphp
<div class="page-sidebar">
    {{-- <div class="page-sidebar-header py-2 text-white px-3 align-items-center JU d-flex">
        <div class="me-3 position-relative">
            <img src="{{ asset('panel-assets/images/art-logo.png') }}" alt="" style="max-height:47px">
        </div>
        <div>
            <h6 class="mb-2">
                {{config('app.name')}}
            </h6>
            <a href="{{route('frontend.home')}}" target="_blank" class="goToWebsite-btn">@lang('Go to website') <span class="link-icon"><i class="fa fa-link"></i></span></a>
        </div>
    </div> --}}
    <div class="page-sidebar-header py-2 text-white px-3 align-items-center JU d-flex">
        <div class="me-3 position-relative">
            <img src="{{ auth()->user()->avatar_url }}" alt="" class="avatar-40">
        </div>
        <div class="position-relative">
            <div class="mb-1 fs-6">
                {{auth()->user()->fullname}}
            </div>
            <div class="sidebar-user d-flex align-items-center" style="gap: 7px;">
                <span class="__">
                    @role('admin')
                    مدير الموقع
                    @elserole('artist')
                    فنان
                    @elserole('store')
                    متجر متخصص
                    @elserole('financial')
                    متجر متخصص
                    @endrole
                </span>
                <a href="{{route('frontend.home')}}" target="_blank" class="__ bg-secondary">@lang('Go to website') <span class="link-icon"><i class="bi bi-chevron-left"></i></span></a>
            </div>
        </div>
    </div>
    <div class="page-sidebar-menu">
        <ul>
            @foreach ($sidebar_list as $sb_item)
                @if ($sb_item['cond'] ?? true)
                    <li class="page-sidebar-menu__item {{ Str::contains($sb_item['href'], $req_url) ? 'active' : '' }}">
                        <a href="{{ $sb_item['href'] ?? 'javascript:;' }}">
                            <i class="{{ $sb_item['icon'] }}"></i>
                            <span>@lang($sb_item['title'])</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
