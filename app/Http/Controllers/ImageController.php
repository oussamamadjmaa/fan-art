<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Storage;

class ImageController extends Controller
{
    protected $storage;
    public function __construct()
    {
        $this->storage = Storage::disk('public');
    }

    public function index($size, $path) {
        abort_if(!in_array($size, [300, 500, 900])
                    || !$this->storage->fileExists($path)
                    || !in_array($fileExt = strtolower(pathinfo($path, PATHINFO_EXTENSION)), ['png', 'jpg', 'jpeg', 'webp'])
            , 404);

        //WaterMark Logo
        $waterMark = Image::cache(function($image) use($size) {
            $image->make($this->storage->path(config('app.logo')))->resize($size/7, null, function($const) {
                $const->aspectRatio();
            });
        }, 1440);

        //Respone Image
        $img = Image::cache(function($image) use($path, $size, $waterMark) {
            $image->make($this->storage->path($path))->resize($size, $size, function($const) {
                $const->aspectRatio();
            })->insert($waterMark, 'bottom-left', 5, 5);
        }, 1440);

        return response($img, 200, ['Content-Type' => 'image/'.$fileExt]);
    }
}
