<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Meta;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ArtworkMessageRequest;
use App\Models\Artwork;
use Illuminate\Http\Request;

class ArtworksController extends Controller
{
    public function index(){
         //Page meta data
         $meta = new Meta([
            'title' => __('Paintings and artwork'),
        ]);

        //
        $artworks = Artwork::query();
        $artworks = $artworks->activeSubscribedArtist()->latest('artworks.created_at')->paginate(12);

        if($artworks->currentPage() > $artworks->lastPage()) {
            return redirect(request()->fullUrlWithQuery(['page' => $artworks->lastPage()]));
        }

        return view('Frontend.Artworks.index', compact('artworks'));
    }

    public function show(Artwork $artwork){
        $artwork->load(['user' => fn($q) => $q->activeSubscribedArtist()]);
        abort_if(!$artwork->user, 404);

        //Page meta data
        $meta = new Meta([
            'title' => $artwork->title,
            'description' => str($artwork->description)->limit(160)->toString(),
            'image'    => storage_url($artwork->image)
        ]);

        //Visits count
        if(!auth()->check() || auth()->id() != $artwork->user_id){
            $visits = $artwork->visits()->firstOrCreate(['visits_date' => now()->format('Y-m-d')], ['count' => 0]);
            $visits->increment('count');
        }

        return view('Frontend.Artworks.show', compact('artwork'));
    }

    public function send_message(ArtworkMessageRequest $request, Artwork $artwork){
        $artwork->load(['user' => fn($q) => $q->activeSubscribedArtist()]);
        abort_if(!$artwork->user, 404);

        if($artwork->hasMessageFromThisSender()){
            return response()->json(['status' => 403, 'message' => __("You already been sent a message about this artwork!")], 403);
        }
        $message = $artwork->messages()->create($this->send_message_data($request));
        $notification = $artwork->notifications()->create([
            'from_user_id'  => auth()->check() ? auth()->id() : null,
            'to_user_id'    => $artwork->user_id,
            'type'          => 'artworks.new_message',
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
