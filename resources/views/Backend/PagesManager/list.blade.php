@forelse ($pages ?? [] as $page)
    @include('Backend.PagesManager.partials.signle')
@empty
<div class="p-3 no-data">
    @lang('No Data')
</div>
@endforelse
