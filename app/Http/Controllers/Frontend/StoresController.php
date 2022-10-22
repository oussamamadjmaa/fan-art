<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Meta;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    public function index(){
        //Page meta data
        $meta = new Meta([
            'title' => __('Stores'),
        ]);

        $stores = User::role('store')->activeVerifiedSubscribed()
            ->latest()
            ->paginate(16);

        if ($stores->currentPage() > $stores->lastPage()) {
            return redirect(request()->fullUrlWithQuery(['page' => $stores->lastPage()]));
        }

        return view('Frontend.Stores.index', compact('stores'));
    }
}
