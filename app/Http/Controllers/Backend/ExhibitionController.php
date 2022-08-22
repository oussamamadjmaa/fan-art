<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ExhibitionRequest;
use App\Models\Exhibition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ExhibitionController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Exhibition::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->expectsJson()){
            $exhibitions = (auth()->user()->hasRole('admin')) ? Exhibition::query()->withWhereHas('user') : auth()->user()->exhibitions();
            $exhibitions = $exhibitions->with('sponsor')->latest()->cursorPaginate(15)->withQueryString();
            $slot = array_merge($exhibitions->toArray(), ['data' => view('Backend.Exhibition.list', compact('exhibitions'))->render()]);
            return response()->json($slot);
        }
        return view('Backend.Exhibition.index');
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
    public function store(ExhibitionRequest $request)
    {
        $exhibition = auth()->user()->exhibitions()->create($request->validated());
        view()->share('class', 'new-eff');
        return response()->json(['status' => 200, 'message' => __('Data Created Successfully'), 'prepend' => ['target' => '#page-data-list', 'content' => view('Backend.Exhibition.partials.signle', compact('exhibition'))->render()]]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Exhibition $exhibition)
    {
        return $this->form($exhibition);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExhibitionRequest $request, Exhibition $exhibition)
    {
        $exhibition->update($request->validated());
        view()->share('class', 'new-eff');
        return response()->json(['status' => 200, 'message' => __('Data Updated Successfully'), 'new_content' => ['target' => '#exhibition_'.$exhibition->id, 'content' => view('Backend.Exhibition.partials.signle', compact('exhibition'))->render()]]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exhibition $exhibition)
    {
        if($exhibition->delete()){
            return response()->json(['status' => 200, 'message' => __('Data Deleted Successfully'), 'target' => "#exhibition_".$exhibition->id]);
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
            $exhibition = Exhibition::find($id);
            if($exhibition && Gate::allows('delete', $exhibition)){
                $exhibition->delete();
                $targets[] = "#exhibition_".$id;
            }
        }
        if(count($targets)) return response()->json(['status' => 200, 'message' => __('Data Deleted Successfully'), 'targets' => implode(',', $targets)]);
        return abort(403, __('This action is unauthorized.'));
    }

    private function form(Exhibition $exhibition = NULL){
        abort_if(!request()->expectsJson(), 404);
        $countries_list = countries_list();
        $sponsors = auth()->user()->sponsors()->get();
        return response()->json(['form' => view('Backend.Exhibition.form', compact('exhibition', 'sponsors'))->render()]);
    }
}
