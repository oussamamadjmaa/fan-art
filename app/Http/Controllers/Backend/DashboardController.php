<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Exhibition;
use App\Models\Message;
use App\Models\News;
use App\Models\Product;
use App\Models\Visit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        if(request()->expectsJson() && request()->ajax()){
            $data = [];
            if(auth()->user()->hasRole('artist')){
                //Latest messages about artworks
                $latest_artworks_messages = Message::with('sender')->whereHasMorph('messageable', [Artwork::class], fn($q) => $q->where('user_id', auth()->id()))->with('messageable')->latest('id')->limit(10)->get();
                $data['latest_artworks_messages'] = view('Backend.Artwork.partials.messages_list')->with(['messages' => $latest_artworks_messages, 'show_artwork_title' => true])->render();
            }else if(auth()->user()->hasRole('store')){
                //Latest messages about products
                $latest_products_messages = Message::with('sender')->whereHasMorph('messageable', [Product::class], fn($q) => $q->where('user_id', auth()->id()))->with('messageable')->latest('id')->limit(10)->get();
                $data['latest_products_messages'] = view('Backend.Product.partials.messages_list')->with(['messages' => $latest_products_messages, 'show_product_name' => true])->render();
            }
            return response()->json($data);
        }

        //Stats
        $durations = [
            'Today' => now(),
            'Last 30 days' => now()->subDays(30),
            'Last year' => now()->subYear()
        ];
        $duration = $durations[request()->get('duration', 'Last 30 days')] ?? now()->subDays(30);
        $visit_stats = [];
        if (auth()->user()->hasRole('artist')) {
            $visit_stats = [
                'profile' => auth()->user()->visits()->whereDate('visits_date', '>=', $duration)->sum('count'),
                'artworks' => Visit::whereHasMorph('visitable', [Artwork::class], fn($q) => $q->where('user_id', auth()->id()))->whereDate('visits_date', '>=', $duration)->sum('count'),
                'blog' => Visit::whereHasMorph('visitable', [News::class], fn($q) => $q->where('user_id', auth()->id()))->whereDate('visits_date', '>=', $duration)->sum('count'),
                'exhibitions' => Visit::whereHasMorph('visitable', [Exhibition::class], fn($q) => $q->where('user_id', auth()->id()))->whereDate('visits_date', '>=', $duration)->sum('count')
            ];
        }else if(auth()->user()->hasRole('store')){
            $visit_stats = [
                'profile' => auth()->user()->visits()->whereDate('visits_date', '>=', $duration)->sum('count'),
                'products' => Visit::whereHasMorph('visitable', [Product::class], fn($q) => $q->where('user_id', auth()->id()))->whereDate('visits_date', '>=', $duration)->sum('count'),
            ];
        }

        view()->share('visit_stats', $visit_stats);

        return view('Backend.dashboard');
    }
}
