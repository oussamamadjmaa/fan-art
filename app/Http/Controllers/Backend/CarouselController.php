<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CarouselRequest;
use App\Models\Carousel;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->expectsJson()){
            $carousels = Carousel::latest()->cursorPaginate(15)->withQueryString();
            $slot = array_merge($carousels->toArray(), ['data' => view('Backend.Carousel.list', compact('carousels'))->render()]);
            return response()->json($slot);
        }
        $carousels = Carousel::active()->oldest('order')->get();
        return view('Backend.Carousel.index', compact('carousels'));
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
    public function store(CarouselRequest $request)
    {
        $carousel = Carousel::create($request->validated());
        view()->share('class', 'new-eff');
        return response()->json(['status' => 200, 'message' => __('Data Created Successfully'), 'prepend' => ['target' => '#page-data-list', 'content' => view('Backend.Carousel.partials.signle', compact('carousel'))->render()]]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Carousel $carousel)
    {
        return $this->form($carousel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CarouselRequest $request, Carousel $carousel)
    {
        $carousel->update($request->validated());
        view()->share('class', 'new-eff');
        return response()->json(['status' => 200, 'message' => __('Data Updated Successfully'), 'new_content' => ['target' => '#carousel_'.$carousel->id, 'content' => view('Backend.Carousel.partials.signle', compact('carousel'))->render()]]);

    }

    public function toggle_status(Request $request, Carousel $carousel){
        $carousel->status = $request->input('status', false) == "true" ? 1 : 0;
        $carousel->save();
        return response()->json(['status' => 200, 'message' => __('Data Updated Successfully')]);
    }

    public function reorder(Request $request){
        $request->validate(['carousel' => 'required|array']);

        foreach ($request->carousel as $key => $order) {
            $carousel = Carousel::find($key);
            if($carousel){
                $carousel->order = (int)$order+1;
                $carousel->save();
            }
        }
        return response()->json(['status' => 200, 'message' => __('Data Updated Successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carousel $carousel)
    {
        if($carousel->delete()){
            return response()->json(['status' => 200, 'message' => __('Data Deleted Successfully'), 'target' => "#carousel_".$carousel->id]);
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
            $carousel = Carousel::find($id);
            if($carousel){
                $carousel->delete();
                $targets[] = "#carousel_".$id;
            }
        }
        if(count($targets)) return response()->json(['status' => 200, 'message' => __('Data Deleted Successfully'), 'targets' => implode(',', $targets)]);
        return abort(403, __('This action is unauthorized.'));
    }

    private function form(Carousel $carousel = NULL){
        abort_if(!request()->expectsJson(), 404);
        return response()->json(['form' => view('Backend.Carousel.form', compact('carousel'))->render()]);
    }
}
