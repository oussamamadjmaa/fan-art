@forelse ($exhibitions ?? [] as $exhibition)
    @include('Backend.Exhibition.partials.signle')
@empty
<div class="p-3 no-data">
    @lang('No Data')
</div>
@endforelse
