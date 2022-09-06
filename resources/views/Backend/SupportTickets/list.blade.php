@forelse ($tickets as $ticket)
    @include('Backend.SupportTickets.partials.single')
@empty
<div class="p-3 no-data">
    @lang('No Data')
</div>
@endforelse
