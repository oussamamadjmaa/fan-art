<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BlogRequest;
use App\Models\News;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(News::class, 'blog');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->expectsJson()){
            $blogs = (auth()->user()->hasRole('admin')) ? News::query()->withWhereHas('user', fn($q) => $q->role('artist')) : auth()->user()->news();
            $blogs = $blogs->latest()->cursorPaginate(15)->withQueryString();
            $slot = array_merge($blogs->toArray(), ['data' => view('Backend.Blog.list', compact('blogs'))->render()]);
            return response()->json($slot);
        }
        return view('Backend.Blog.index');
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
    public function store(BlogRequest $request)
    {
        $blog = News::create($request->validated());
        view()->share('class', 'new-eff');
        return response()->json(['status' => 200, 'message' => __('Data Created Successfully'), 'prepend' => ['target' => '#page-data-list', 'content' => view('Backend.Blog.partials.signle', compact('blog'))->render()]]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(News $blog)
    {
        return $this->form($blog);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, News $blog)
    {
        $blog = $blog;
        $blog->update($request->validated());
        view()->share('class', 'new-eff');
        return response()->json(['status' => 200, 'message' => __('Data Updated Successfully'), 'new_content' => ['target' => '#blog_'.$blog->id, 'content' => view('Backend.Blog.partials.signle', compact('blog'))->render()]]);

    }

    public function toggle_status(Request $request, News $blog){
        $blog->status = $request->input('status', false) == "true" ? 1 : 0;
        $blog->save();
        return response()->json(['status' => 200, 'message' => __('Data Updated Successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $blog)
    {
        if($blog->delete()){
            return response()->json(['status' => 200, 'message' => __('Data Deleted Successfully'), 'target' => "#blog_".$blog->id]);
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
            $blog = News::find($id);
            if($blog){
                $blog->delete();
                $targets[] = "#blog_".$id;
            }
        }
        if(count($targets)) return response()->json(['status' => 200, 'message' => __('Data Deleted Successfully'), 'targets' => implode(',', $targets)]);
        return abort(403, __('This action is unauthorized.'));
    }

    private function form(News $blog = NULL){
        abort_if(!request()->expectsJson(), 404);
        return response()->json(['form' => view('Backend.Blog.form', compact('blog'))->render()]);
    }
}
