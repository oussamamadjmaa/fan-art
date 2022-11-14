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

        session_cache_limiter('none');
        header('Content-Type:image/'.$fileExt);
        header('Cache-Control: max-age='.(60*60*24*365));
        header('Expires: '.gmdate(DATE_RFC1123, time()+60*60*24*365));
        header('Last-Modified: '.gmdate(DATE_RFC1123,filemtime($this->storage->path($path))));

        if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
            header('HTTP/1.1 304 Not Modified');
        }

        echo $img;
    }
}
/*
Accept-Ranges: bytes
Connection: Keep-Alive
Date: Mon, 14 Nov 2022 08:38:47 GMT
ETag: "14e21-5e5e3a1330ad4"
Keep-Alive: timeout=5, max=100
Last-Modified: Wed, 10 Aug 2022 14:11:48 GMT
Server: Apache/2.4.53 (Win64) OpenSSL/1.1.1n PHP/8.0.19
*/
