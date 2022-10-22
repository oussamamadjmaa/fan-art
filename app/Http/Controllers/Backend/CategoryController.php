<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Category::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->expectsJson()){
            $categories = (auth()->user()->hasRole('admin')) ? Category::query()->withWhereHas('user') : auth()->user()->categories();
            $categories = $categories->latest('id')->cursorPaginate(15)->withQueryString();
            $slot = array_merge($categories->toArray(), ['data' => view('Backend.Category.list', compact('categories'))->render()]);
            return response()->json($slot);
        }
        return view('Backend.Category.index');
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
    public function store(CategoryRequest $request)
    {
        $category = auth()->user()->categories()->create($request->validated());
        view()->share('class', 'new-eff');
        return response()->json(['status' => 200, 'message' => __('Data Created Successfully'), 'prepend' => ['target' => '#page-data-list', 'content' => view('Backend.Category.partials.signle', compact('category'))->render()]]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return $this->form($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        view()->share('class', 'new-eff');
        return response()->json(['status' => 200, 'message' => __('Data Updated Successfully'), 'new_content' => ['target' => '#category_'.$category->id, 'content' => view('Backend.Category.partials.signle', compact('category'))->render()]]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->delete()){
            return response()->json(['status' => 200, 'message' => __('Data Deleted Successfully'), 'target' => "#category_".$category->id]);
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
            $category = Category::find($id);
            if($category && Gate::allows('delete', $category)){
                $category->delete();
                $targets[] = "#category_".$id;
            }
        }
        if(count($targets)) return response()->json(['status' => 200, 'message' => __('Data Deleted Successfully'), 'targets' => implode(',', $targets)]);
        return abort(403, __('This action is unauthorized.'));
    }

    private function form(Category $category = NULL){
        abort_if(!request()->expectsJson(), 404);
        $countries_list = countries_list();
        return response()->json(['form' => view('Backend.Category.form', compact('category'))->render()]);
    }
}
