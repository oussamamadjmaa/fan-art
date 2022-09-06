<tr @class(['bg-warning' => auth()->id() != $ticket->last_message?->sender_id && is_null($ticket->last_message?->seen_at)])>
    <td><a href="{{ route('backend.support_tickets.show', $ticket->id) }}">{{ $ticket->id }}</a></td>
    <td><a href="{{ route('backend.support_tickets.show', $ticket->id) }}" class="text-dark">{{ $ticket->subject }}</a></td>
    <td>{{ $ticket->user_id == $ticket->last_message?->sender_id ? (auth()->id() == $ticket->user_id ? __('You') : $ticket->user->name) : __('Fanart Support') }}</td>
    <td >{{ $ticket->created_at->translatedFormat('l d M Y h:i A') }}</td>
    <td>{{ $ticket->updated_at->translatedFormat('l d M Y h:i A') }}</td>
    <td>{{ __($ticket->status == $ticket::OPENED ? 'Opened' : 'Closed')  }}</td>
</tr>
