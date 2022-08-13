@forelse ($sponsors ?? [] as $sponsor)
    @include('Backend.Sponsor.partials.signle')
@empty
<div class="p-3 no-data">
    @lang('No Data')
</div>
@endforelse
