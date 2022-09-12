<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Meta;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StoreProfileController extends Controller
{
    public function index($store_username){
        $store = User::role('store')->whereUsername($store_username)->activeVerifiedSubscribed()->firstOrFail();

        //Visits count
        if(!auth()->check() || auth()->id() != $store->id){
            $visits = $store->visits()->firstOrCreate(['visits_date' => now()->format('Y-m-d')], ['count' => 0]);
            $visits->increment('count');
        }

        //Page meta data
        $meta = new Meta([
            'title' => $store->name,
            'description' => str($store->address)->limit(160)->toString(),
            'image'    => $store->avatar_url
        ]);

        //Filtering
        $sortByList = ['latest' => 'Latest', 'lowest_price' => 'Price (Low to High)' , 'highest_price' => 'Price (High to Low)', 'oldest' => 'Oldest'];
        $currentSortBy = request()->get('sortBy', 'latest');

        $categories = $store->categories()->latest()->get();

        $category = request()->get('categoryId') ? $categories->where('id', request()->get('categoryId'))->first() : NULL;
        //Store products
        $store_products = $store->products()
                            ->with('category:id,name')
                            ->when(($currentSortBy == 'latest' || !array_key_exists($currentSortBy, $sortByList)) , fn($q) => $q->latest())
                            ->when(($currentSortBy == 'highest_price') , fn($q) => $q->latest('price'))
                            ->when(($currentSortBy == 'lowest_price') , fn($q) => $q->oldest('price'))
                            ->when(($currentSortBy == 'oldest') , fn($q) => $q->oldest())
                            ->when(($category), fn($q) => $q->where('category_id', $category->id))
                            ->paginate(16);
        if($store_products->currentPage() > $store_products->lastPage()) {
            return redirect(request()->fullUrlWithQuery(['page' => $store_products->lastPage()]));
        }

        return view('Frontend.Store.profile', compact('store', 'store_products', 'sortByList', 'currentSortBy', 'category', 'categories'));
    }
}
