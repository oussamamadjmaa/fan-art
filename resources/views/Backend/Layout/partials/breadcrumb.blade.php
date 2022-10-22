<div class="main-breadcrumb bg-white">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}"><i class="bi bi-house-door me-1"></i> @lang('Dashboard')</a></li>
            <li class="breadcrumb-item active">{{ $meta->title ?? $title ??'' }}</li>
        </ol>
    </nav>
</div>
