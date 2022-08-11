@if (request()->segment(2) != "dashboard")
<nav aria-label="breadcrumb" class="mb-md-5 mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}"><i class="bi bi-house-door me-1"></i> @lang('Dashboard')</a></li>
        <li class="breadcrumb-item active">{{ $meta->title ?? $title ??'' }}</li>
    </ol>
</nav>
@endif
