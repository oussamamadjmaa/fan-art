<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Meta;
use App\Http\Controllers\Controller;
use App\Models\HotelArtworksOrder;
use App\Models\User;
use Illuminate\Http\Request;

class HotelArtworksOrderController extends Controller
{
    public function index() {
        //Page meta data
        $meta = new Meta([
            'title' => __('طلب لوحات فنية خاصة بالفنادق'),
        ]);

        return view('Frontend.HotelArtworksOrder.index');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'facility_name' => 'nullable|string|max:255',
            'responsible_person' => 'required|string|between:3,255',
            'city' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'quantity' => 'required|numeric|max:999',
            'sizes' => 'required|string|max:255',
            'idea' => 'nullable|string|max:3000',
        ]);

        $data['ip_address'] = $request->ip();

        if(HotelArtworksOrder::where('ip_address', $data['ip_address'])->exists()) {
            return redirect()->back()->withError(__("لا يمكنك تقديم أكثر من طلب في نفس اليوم"));
        }

        $order = HotelArtworksOrder::create($data);

        $admins = User::role('admin')->get();

        foreach ($admins as $admin) {
            $notification = $order->notifications()->create([
                'from_user_id'  => auth()->id(),
                'to_user_id'    => $admin->id,
                'type'          => 'orders.hotel_artworks_order',
            ]);
        }

        return redirect()->back()->withSuccess(__("Order has been placed successfully"));
    }
}
