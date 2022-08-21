<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Exhibition;
use Illuminate\Http\Request;

class ExhibitionsController extends Controller
{
    public function index(Request $request){
        $exhibitions = Exhibition::when($request->city && $request->city != "all", fn($q) => $q->where('city', $request->city))
      //  ->where(fn($q) => $q->whereDate('from_date', '>=', now())->orWhereDate('to_date', '>=', now()))
        ->with('sponsor')
        ->withWhereHas('user', fn($q) => $q->activeSubscribedArtist())
        ->oldest('from_date')
        ->paginate(12);

        return view('Frontend.Exhibitons.index', compact('exhibitions'));
    }

    public function show(Exhibition $exhibition){
        return view('Frontend.Exhibitons.show', compact('exhibition'));
    }
}
