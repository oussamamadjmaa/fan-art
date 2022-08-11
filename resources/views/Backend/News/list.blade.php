@forelse ($news ?? [] as $singleNews)
    @include('Backend.News.partials.signle')
@empty
<div class="p-3 no-data">
    @lang('No Data')
</div>
@endforelse
