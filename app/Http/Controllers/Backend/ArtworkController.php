<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ArtworkRequest;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArtworkController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Artwork::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->expectsJson()){
            $artworks = (auth()->user()->hasRole('admin')) ? Artwork::query()->withWhereHas('user') : auth()->user()->artworks();
            $artworks = $artworks->latest()->cursorPaginate(15)->withQueryString();
            $slot = array_merge($artworks->toArray(), ['data' => view('Backend.Artwork.list', compact('artworks'))->render()]);
            return response()->json($slot);
        }
        return view('Backend.Artwork.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->form();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArtworkRequest $request)
    {
        $artwork = auth()->user()->artworks()->create($request->validated());
        view()->share('class', 'new-eff');
        return response()->json(['status' => 200, 'message' => __('Data Created Successfully'), 'prepend' => ['target' => '#page-data-list', 'content' => view('Backend.Artwork.partials.signle', compact('artwork'))->render()]]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Artwork $artwork)
    {
        return $this->form($artwork);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArtworkRequest $request, Artwork $artwork)
    {
        $artwork->update($request->validated());
        view()->share('class', 'new-eff');
        return response()->json(['status' => 200, 'message' => __('Data Updated Successfully'), 'new_content' => ['target' => '#artwork_'.$artwork->id, 'content' => view('Backend.Artwork.partials.signle', compact('artwork'))->render()]]);

    }

    public function toggle_status(Request $request, Artwork $artwork){
        abort_if(Gate::denies('update', $artwork), 404);
        $request->validate([
            'status' => 'required|in:0,1,2'
        ]);
        $artwork->status = $request->status;
        $artwork->save();
        return response()->json(['status' => 200, 'message' => __('Data Updated Successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artwork $artwork)
    {
        if($artwork->delete()){
            return response()->json(['status' => 200, 'message' => __('Data Deleted Successfully'), 'target' => "#artwork_".$artwork->id]);
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
            $artwork = Artwork::find($id);
            if($artwork && Gate::allows('delete', $artwork)){
                $artwork->delete();
                $targets[] = "#artwork_".$id;
            }
        }
        if(count($targets)) return response()->json(['status' => 200, 'message' => __('Data Deleted Successfully'), 'targets' => implode(',', $targets)]);
        return abort(403, __('This action is unauthorized.'));
    }

    private function form(Artwork $artwork = NULL){
        abort_if(!request()->expectsJson(), 404);
        return response()->json(['form' => view('Backend.Artwork.form', compact('artwork'))->render()]);
    }
}
