<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index(){
        if(request()->expectsJson()){
            $tickets = (auth()->user()->hasRole('admin')) ? SupportTicket::query() : auth()->user()->support_tickets();
            $tickets = $tickets->withWhereHas('user', fn($q) => $q->select('id', 'name'))->with('last_message')->latest('updated_at')->cursorPaginate(20)->withQueryString();
            $slot = array_merge($tickets->toArray(), ['data' => view('Backend.SupportTickets.list', compact('tickets'))->render()]);
            return response()->json($slot);
        }
        return view('Backend.SupportTickets.index');
    }

    public function create(){
        return response()->json(['form' => view('Backend.SupportTickets.create')->render()]);
    }

    public function store(Request $request){
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:191'],
            'message' => ['required', 'string', 'max:700'],
        ]);
        $data['status'] = SupportTicket::OPENED;

        //Create new support ticket
        $ticket = auth()->user()->support_tickets()->create($data);

        //Store ticket message
        $ticket->last_message()->create([
            'sender_id' => auth()->id(),
            'sender_type' => 'App\Models\User',
            'body'  => $data['message'],
            'data' => ['ip_address'    => $request->ip()],
        ]);

        return response()->json(['status' => 200, 'message' => __('Data Created Successfully'), 'prepend' => ['target' => '#page-data-list', 'content' => view('Backend.SupportTickets.partials.single', compact('ticket'))->render()]]);

    }

    public function show(SupportTicket $support_ticket){
        abort_if((int) $support_ticket->user_id != (int) auth()->id() && !auth()->user()->hasRole('admin'), 404);
        $support_ticket->load(['messages' => fn($q) => $q->latest()]);

        //Mark messages as seen
        $support_ticket->messages()->when(auth()->user()->hasRole('admin'), fn($q) => $q->where('sender_id', $support_ticket->user_id), fn($q) => $q->where('sender_id', '!=', $support_ticket->user_id))->update(['seen_at' => now()]);

        return view('Backend.SupportTickets.show', compact('support_ticket'));
    }

    public function send_message(Request $request, SupportTicket $support_ticket){
        abort_if($support_ticket->status != $support_ticket::OPENED, 404);
        $data = $request->validate([
            'message' => ['required', 'string', 'max:700'],
        ]);

        //Store ticket message
        $support_ticket->last_message()->create([
            'sender_id' => auth()->id(),
            'sender_type' => 'App\Models\User',
            'body'  => $data['message'],
            'data' => ['ip_address'    => $request->ip()],
        ]);

        $support_ticket->touch();

        return to_route('backend.support_tickets.show', $support_ticket->id)->withSuccess(__('Your message has been sent successfully'));
    }

    public function close_ticket(SupportTicket $support_ticket){
        abort_if((int) $support_ticket->user_id != (int) auth()->id() && !auth()->user()->hasRole('admin'), 404);

        if($support_ticket->status == $support_ticket::OPENED){
            $support_ticket->status = $support_ticket::CLOSED;
            $support_ticket->save();

            return to_route('backend.support_tickets.show', $support_ticket->id)->withSuccess(__('This support ticket has been closed successfully'));
        }else {
            return to_route('backend.support_tickets.show', $support_ticket->id);
        }


    }
}
