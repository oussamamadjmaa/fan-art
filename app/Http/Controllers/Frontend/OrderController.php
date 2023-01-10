<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Order;
use App\Models\User;
use App\Rules\ValidateFileRule;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        $orders = auth()->user()->orders()->withWhereHas('orderable')->paginate(15);
        return view('Frontend.Orders.index', compact('orders'));
    }
    public function store(Request $request, Artwork $artwork) {
        $artwork->load(['user' => fn($q) => $q->activeSubscribedArtist()]);
        abort_if(!$artwork->user, 404);

        $request->validate([
            'bank_transfer_receipt' => ['required', 'mimetypes:image/png,image/jpeg,image/webp'],
        ]);

        if(auth()->user()->orders()->whereMorphRelation('orderable', Artwork::class, 'id', $artwork->id)->whereNull('confirmed_at')->whereNull('canceled_at')->whereNull('denied_at')->exists()){
            return response()->json(['status' => 403, 'message' => __("You already has been placed an order for this artwork!")], 403);
        }

        $data = [
            'user_id' => auth()->id(),
            'payment_method' => 'bank_transfer',
            'amount' => $artwork->price/100
        ];

        if($request->hasFile('bank_transfer_receipt')) {
            $data['bank_transfer_receipt'] = $request->file('bank_transfer_receipt')->store('order_confirmation_pictures', 'public');
            $data['paid_at'] = now();
        }

        $artwork->orders()->create($data);

        $admins = User::role('admin')->get();

        foreach ($admins as $admin) {
            $notification = $artwork->notifications()->create([
                'from_user_id'  => auth()->id(),
                'to_user_id'    => $admin->id,
                'type'          => 'orders.new_artwork_order',
            ]);
        }

        return response()->json(['status' => 200, 'message' => __("Order has been placed successfully")]);
    }
}
