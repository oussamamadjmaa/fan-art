<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\NewsRequest;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->expectsJson()){
            $news = (auth()->user()->hasRole('admin')) ? News::query()->withWhereHas('user', fn($q) => $q->role('admin')) : auth()->user()->news();
            $news = $news->latest('id')->cursorPaginate(15)->withQueryString();
            $slot = array_merge($news->toArray(), ['data' => view('Backend.News.list', compact('news'))->render()]);
            return response()->json($slot);
        }
        return view('Backend.News.index');
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
    public function store(NewsRequest $request)
    {
        $singleNews = News::create($request->validated());
        view()->share('class', 'new-eff');
        return response()->json(['status' => 200, 'message' => __('Data Created Successfully'), 'prepend' => ['target' => '#page-data-list', 'content' => view('Backend.News.partials.signle', compact('singleNews'))->render()]]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        return $this->form($singleNews = $news);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, News $news)
    {
        $singleNews = $news;
        $singleNews->update($request->validated());
        view()->share('class', 'new-eff');
        return response()->json(['status' => 200, 'message' => __('Data Updated Successfully'), 'new_content' => ['target' => '#singleNews_'.$singleNews->id, 'content' => view('Backend.News.partials.signle', compact('singleNews'))->render()]]);

    }

    public function toggle_status(Request $request, News $news){
        $singleNews = $news;
        $singleNews->status = $request->input('status', false) == "true" ? 1 : 0;
        $singleNews->save();
        return response()->json(['status' => 200, 'message' => __('Data Updated Successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        $singleNews = $news;
        if($singleNews->delete()){
            return response()->json(['status' => 200, 'message' => __('Data Deleted Successfully'), 'target' => "#singleNews_".$singleNews->id]);
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
            $singleNews = News::find($id);
            if($singleNews){
                $singleNews->delete();
                $targets[] = "#singleNews_".$id;
            }
        }
        if(count($targets)) return response()->json(['status' => 200, 'message' => __('Data Deleted Successfully'), 'targets' => implode(',', $targets)]);
        return abort(403, __('This action is unauthorized.'));
    }

    private function form(News $singleNews = NULL){
        abort_if(!request()->expectsJson(), 404);
        return response()->json(['form' => view('Backend.News.form', compact('singleNews'))->render()]);
    }
}
