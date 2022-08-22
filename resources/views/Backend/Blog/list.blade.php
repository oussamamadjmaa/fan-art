@forelse ($blogs ?? [] as $blog)
    @include('Backend.Blog.partials.signle')
@empty
<div class="p-3 no-data">
    @lang('No Data')
</div>
@endforelse
