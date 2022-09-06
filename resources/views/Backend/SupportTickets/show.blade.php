@extends('Backend.Layout.master', ['title' => __('Support tickets')])
@section('content')
<div>
    <x-buttons.icon-button :text="__('Back to Support tickets')" icon="fa fa-arrow-right" onclick="window.location.href='{{route('backend.support_tickets.index')}}'" />
</div>
<div class="card mt-3">
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="ticket-information mb-3">
            <h3 class="mb-3">@lang('Support ticket information'):</h3>
            <div class="row">
                <div class="col-4 col-md-2 mb-1"><b>@lang('Subject')</b></div>
                <div class="col-8 col-md-4 mb-1">{{$support_ticket->subject}}</div>
                <div class="col-4 col-md-2 mb-1"><b>@lang('Ticket number')</b></div>
                <div class="col-8 col-md-4 mb-1">{{$support_ticket->id}}</div>
                <div class="col-4 col-md-2 mb-1"><b>@lang('Status')</b></div>
                <div class="col-8 col-md-4 mb-1">{{$support_ticket->status_text}}</div>
                <div class="col-4 col-md-2 mb-1"><b>@lang('Creation date')</b></div>
                <div class="col-8 col-md-4 mb-1">{{$support_ticket->created_at->translatedFormat('l d M Y h:i A')}}</div>
                <div class="col-4 col-md-2 mb-1"><b>@lang('Last update')</b></div>
                <div class="col-8 col-md-4 mb-1">{{$support_ticket->updated_at->translatedFormat('l d M Y h:i A')}}</div>
            </div>
            @if ($support_ticket->status == $support_ticket::OPENED)
            <div class="mt-3">
                <form action="{{route('backend.support_tickets.close_ticket', $support_ticket->id)}}" method="POST" id="closeTicketForm">
                    @csrf
                    @method('PUT')
                    <button type="button" class="btn btn-danger" id="closeTicketBtn" data-confirmation-message="@lang('Do you really want to close this support ticket?')">@lang('Close ticket')</button>
                </form>
            </div>
            @endif
        </div>
        <div class="ticket-messages">
            <h3 class="mb-3">@lang('Messages'):</h3>
            @if ($support_ticket->status == $support_ticket::OPENED)
            <div class="send_message_form mb-3">
                <form action="{{route('backend.support_tickets.send_message', $support_ticket->id)}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="message" class="form-label">@lang('Message')</label>
                        <textarea class="form-control @error('message') is-invalid @enderror" name="message" id="message" rows="3" placeholder="@lang('Message')" required></textarea>
                        <div class="invalid-feedback">
                            @error('message')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <button class="btn btn-primary">@lang('Send message')</button>
                </form>
            </div>
            <hr>
            @endif
            <div class="ticket-messages-list">
                @foreach ($support_ticket->messages as $message)
                <div @class([
                    'ticket-message border py-2 px-3',
                    'bg-light' => $support_ticket->user_id != $message?->sender_id
                ])>
                    <div class="ticket-message-heading">
                        <h6 class="mb-0"><b>@lang('Sender'):</b> {{ $support_ticket->user_id == $message?->sender_id ? (auth()->id() == $support_ticket->user_id ? __('You') : $support_ticket->user->name) : __('Fanart Support') }}</h6>
                        <small class="text-secondary"><i class="bi bi-clock"></i> {{$message->created_at->translatedFormat('l d M Y h:i A')}}</small>
                    </div>
                    <div class="mt-2">
                        <p class="mb-0">
                            {!! nl2br(e($message->body)) !!}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script type="module">
$(function(){
    $(document).on('click', '#closeTicketBtn', function(){
        if (confirm($(this).data('confirmation-message'))) {
            $("#closeTicketForm").submit()
        }
    })
})
</script>
@endpush
