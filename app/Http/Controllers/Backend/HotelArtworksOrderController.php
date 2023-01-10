<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HotelArtworksOrder;
use Illuminate\Http\Request;

class HotelArtworksOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->expectsJson()){
            $orders = HotelArtworksOrder::query();
            $orders = $orders->latest('id')->cursorPaginate(15)->withQueryString();

            $slot = array_merge($orders->toArray(), ['data' => view('Backend.HotelArtworksOrders.list', compact('orders'))->render()]);
            return response()->json($slot);
        }
        return view('Backend.HotelArtworksOrders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HotelArtworksOrder $order)
    {
        if($order->delete()){
            return response()->json(['status' => 200, 'message' => __('Data Deleted Successfully'), 'target' => "#order_".$order->id]);
        }
        return abort(404, __('Not Found'));
    }

    public function multiple_delete(Request $request){
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer'
        ]);
        $targets = [];
        foreach ($request->ids as $id) {
            $order = HotelArtworksOrder::find($id);
            if($order){
                $order->delete();
                $targets[] = "#order_".$id;
            }
        }
        if(count($targets)) return response()->json(['status' => 200, 'message' => __('Data Deleted Successfully'), 'targets' => implode(',', $targets)]);
        return abort(403, __('This action is unauthorized.'));
    }
}
