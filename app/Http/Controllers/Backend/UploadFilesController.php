<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadFilesController extends Controller
{
    public function upload(Request $request){
        //Allowed Paths
        $paths = [];
        if(auth()->user()->hasRole('admin')){
            $paths = ['pages','carousels', 'news'];
        }
        if(auth()->user()->hasRole('artist')){
            $paths = ['artworks'];
        }
        $paths = implode(',', $paths);

        //Request Rules
        $rules = [
            'path' => 'required|in:'.$paths,
            'file' => ['required', 'file', 'max:'.config('app.max_upload_size')],
        ];
        if(in_array($request->path, ['pages', 'carousels', 'news'])){
            $rules['file'][] = 'image';
        }

        $request->validate($rules);

        $path = $request->file('file')->store($request->path.'/'.date('Y-m'), 'public');

        return response()->json(['status' => 200, 'path' => $path, 'path_url' => Storage::url($path)]);
    }
}
