<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Meta;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProductMessageRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function show(Product $product){
        $product->load(['user' => fn($q) => $q->activeVerifiedSubscribed()]);
        abort_if(!$product->user, 404);

        //Page meta data
        $meta = new Meta([
            'title' => $product->title,
            'description' => str($product->description)->limit(160)->toString(),
            'image'    => storage_url($product->image)
        ]);

        //Visits count
        if(!auth()->check() || auth()->id() != $product->user_id){
            $visits = $product->visits()->firstOrCreate(['visits_date' => now()->format('Y-m-d')], ['count' => 0]);
            $visits->increment('count');
        }

        return view('Frontend.Products.show', compact('product'));
    }

    public function send_message(ProductMessageRequest $request, Product $product){
        $product->load(['user' => fn($q) => $q->activeVerifiedSubscribed()]);
        abort_if(!$product->user, 404);

        if($product->hasMessageFromThisSender()){
            return response()->json(['status' => 403, 'message' => __("You already been sent a message about this product!")], 403);
        }
        $message = $product->messages()->create($this->send_message_data($request));
        $notification = $product->notifications()->create([
            'from_user_id'  => auth()->check() ? auth()->id() : null,
            'to_user_id'    => $product->user_id,
            'type'          => 'products.new_message',
        ]);
        return response()->json(['status' => 200, 'message' => __("Your message has been sent successfully")]);
    }

    public function send_message_data($request){
        if(auth()->check()){
            return [
                'sender_id' => auth()->id(),
                'sender_type' => 'App\Models\User',
                'body' => $request->message,
                'data' => ['ip_address'    => $request->ip()],
            ];
        }else{
            return [
                'sender_id' => NULL,
                'sender_type' => NULL,
                'body' => $request->message,
                'data' => [
                    'first_name' =>  $request->first_name,
                    'last_name' =>  $request->last_name,
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'ip_address'    => $request->ip(),
                ],
            ];
        }
    }

}
