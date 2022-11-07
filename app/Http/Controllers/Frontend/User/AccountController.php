<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function upload_avatar(Request $request){
        $request->validate([
            'avatar' => ['required', 'base64image', 'base64mimetypes:image/png', 'base64dimensions:width=512,height=512'],
        ]);

        $folderPath = "avatars/";

        $base64Image = explode(";base64,", $request->avatar);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);
        $file = $folderPath . Str::random(27) . '.'.$imageType;

        Storage::disk('public')->put($file, $image_base64);

        if(auth()->user()->avatar && !str(auth()->user()->avatar)->contains('defaults')) Storage::disk('public')->delete(auth()->user()->avatar);

        auth()->user()->avatar = $file;
        auth()->user()->save();
        return response()->json(['status' => 200, 'avatar_url' => Storage::disk('public')->url($file)]);
    }
}
