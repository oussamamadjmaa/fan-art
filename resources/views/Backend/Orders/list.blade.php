@forelse ($orders ?? [] as $order)
    @include('Backend.Orders.partials.signle')
@empty
<div class="p-3 no-data">
    @lang('No Data')
</div>
@endforelse
