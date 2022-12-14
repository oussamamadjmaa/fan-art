<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InstallController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Install
Route::get('install-website', [InstallController::class, 'index']);

//Auth Routes
Auth::routes(['verify' => true]);
Route::get('register/{role}', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('register/{role}', [RegisterController::class, 'register'])->name('register')->middleware('guest');

//Frontend Routes
Route::as('frontend.')->group(function(){
    require_once __DIR__.'/frontend/web.php';
});

//Backend Routes
Route::prefix('panel')->as('backend.')->middleware(['auth', 'backend-check'])->group(function(){
    require_once __DIR__.'/backend/web.php';
});

//Image Controller
Route::get('imgs/r/{size}/{path}', [ImageController::class, 'index'])->where('path', '.*')->name('image_resize');
