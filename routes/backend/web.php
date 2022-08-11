<?php

use App\Http\Controllers\Backend\ArtworkController;
use App\Http\Controllers\Backend\CarouselController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\NewsController;
use App\Http\Controllers\Backend\PagesManagerController;
use App\Http\Controllers\Backend\UploadFilesController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => to_route('backend.dashboard'));
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

//Admin Routes
Route::group(['middleware' => 'role:admin'], function(){
    //Pages Manager
    Route::delete('pages-manager', [PagesManagerController::class, 'multiple_delete'])->name('pages-manager.multiple_delete');
    Route::put('pages-manager/toggle_status/{page}', [PagesManagerController::class, 'toggle_status'])->name('pages-manager.toggle_status');
    Route::resource('pages-manager', PagesManagerController::class)->parameter('pages-manager', 'page');

    //Carousel
    Route::delete('carousel', [CarouselController::class, 'multiple_delete'])->name('carousel.multiple_delete');
    Route::put('carousel/toggle_status/{carousel}', [CarouselController::class, 'toggle_status'])->name('carousel.toggle_status');
    Route::put('carousel/reorder', [CarouselController::class, 'reorder'])->name('carousel.reorder');
    Route::resource('carousel', CarouselController::class);

    //News
    Route::delete('news', [NewsController::class, 'multiple_delete'])->name('news.multiple_delete');
    Route::put('news/toggle_status/{news}', [NewsController::class, 'toggle_status'])->name('news.toggle_status');
    Route::resource('news', NewsController::class);
});

//Artist Routes
Route::group(['middleware' => ['role:admin|artist', 'backend-check:subscribed']], function(){
    //Pages Manager
    Route::delete('artworks', [ArtworkController::class, 'multiple_delete'])->name('artworks.multiple_delete');
    Route::put('artworks/toggle_status/{artwork}', [ArtworkController::class, 'toggle_status'])->name('artworks.toggle_status');
    Route::resource('artworks', ArtworkController::class);
});


//Upload
Route::post('upload', [UploadFilesController::class, 'upload'])->name('upload');
