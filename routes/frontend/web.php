<?php

use App\Http\Controllers\Frontend\ArtistProfileController;
use App\Http\Controllers\Frontend\ArtistProfileSetupController;
use App\Http\Controllers\Frontend\ArtistsController;
use App\Http\Controllers\Frontend\ArtworksController;
use App\Http\Controllers\Frontend\ExhibitionsController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\User\AccountController;
use Illuminate\Support\Facades\Route;

//Home
Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');

//Artists List
Route::get('/artists', [ArtistsController::class, 'index'])->name('artists.index');

//Artworks
Route::get('/artworks', [ArtworksController::class, 'index'])->name('artworks.index');
Route::get('/artworks/{artwork:slug}', [ArtworksController::class, 'show'])->name('artworks.show');

//Artist Profile
Route::get('/artist/{artist_username}/{profile_page?}', [ArtistProfileController::class, 'index'])->name('artist.profile');

//Exhibitions
Route::get('/exhibitions', [ExhibitionsController::class, 'index'])->name('exhibitions.index');
Route::get('/exhibitions/{exhibition:slug}', [ExhibitionsController::class, 'show'])->name('exhibitions.show');

//
Route::group(['middleware' => ['auth', 'verified']], function(){
    //Account
    Route::controller(AccountController::class)->group(function(){
        Route::post('upload-avatar', 'upload_avatar')->name('account.upload_avatar');
    });

    //Artist Routes
    Route::middleware('role:artist')->controller(ArtistProfileSetupController::class)->group(function(){
        Route::get('setup_profile/{step}', 'index')->name('setup_profile.index');
        Route::post('setup_profile/{step}', 'save')->name('setup_profile.save');
    });
});

//Custom Pages
Route::get('/p/{page:slug}', [PageController::class, 'index'])->name('page');
