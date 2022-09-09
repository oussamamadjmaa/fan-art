@forelse ($categories ?? [] as $category)
    @include('Backend.Category.partials.signle')
@empty
<div class="p-3 no-data">
    @lang('No Data')
</div>
@endforelse
