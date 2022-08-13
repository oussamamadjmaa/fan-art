<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SponsorRequest;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SponsorController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Sponsor::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->expectsJson()){
            $sponsors = (auth()->user()->hasRole('admin')) ? Sponsor::query()->with('user') : auth()->user()->sponsors();
            $sponsors = $sponsors->latest()->cursorPaginate(15)->withQueryString();
            $slot = array_merge($sponsors->toArray(), ['data' => view('Backend.Sponsor.list', compact('sponsors'))->render()]);
            return response()->json($slot);
        }
        return view('Backend.Sponsor.index');
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
    public function store(SponsorRequest $request)
    {
        $sponsor = auth()->user()->sponsors()->create($request->validated());
        view()->share('class', 'new-eff');
        return response()->json(['status' => 200, 'message' => __('Data Created Successfully'), 'prepend' => ['target' => '#page-data-list', 'content' => view('Backend.Sponsor.partials.signle', compact('sponsor'))->render()]]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Sponsor $sponsor)
    {
        return $this->form($sponsor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SponsorRequest $request, Sponsor $sponsor)
    {
        $sponsor->update($request->validated());
        view()->share('class', 'new-eff');
        return response()->json(['status' => 200, 'message' => __('Data Updated Successfully'), 'new_content' => ['target' => '#sponsor_'.$sponsor->id, 'content' => view('Backend.Sponsor.partials.signle', compact('sponsor'))->render()]]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sponsor $sponsor)
    {
        if($sponsor->delete()){
            return response()->json(['status' => 200, 'message' => __('Data Deleted Successfully'), 'target' => "#sponsor_".$sponsor->id]);
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
            $sponsor = Sponsor::find($id);
            if($sponsor && Gate::allows('delete', $sponsor)){
                $sponsor->delete();
                $targets[] = "#sponsor_".$id;
            }
        }
        if(count($targets)) return response()->json(['status' => 200, 'message' => __('Data Deleted Successfully'), 'targets' => implode(',', $targets)]);
        return abort(403, __('This action is unauthorized.'));
    }

    private function form(Sponsor $sponsor = NULL){
        abort_if(!request()->expectsJson(), 404);
        $countries_list = countries_list();
        return response()->json(['form' => view('Backend.Sponsor.form', compact('sponsor'))->render()]);
    }
}
