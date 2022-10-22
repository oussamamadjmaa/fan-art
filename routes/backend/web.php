<?php

use App\Http\Controllers\Backend\AccountController;
use App\Http\Controllers\Backend\Admin\SubscriptionsController;
use App\Http\Controllers\Backend\Admin\WebsiteSettingsController;
use App\Http\Controllers\Backend\ArtworkController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\CarouselController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ExhibitionController;
use App\Http\Controllers\Backend\NewsController;
use App\Http\Controllers\Backend\NotificationsController;
use App\Http\Controllers\Backend\PagesManagerController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SponsorController;
use App\Http\Controllers\Backend\SubscriptionController;
use App\Http\Controllers\Backend\SupportTicketController;
use App\Http\Controllers\Backend\UpdateController;
use App\Http\Controllers\Backend\UploadFilesController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => to_route('backend.dashboard'));
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

//Admin Routes
Route::group(['middleware' => 'role:admin'], function(){
    //Pages Manager
    Route::delete('pages-manager', [PagesManagerController::class, 'multiple_delete'])->name('pages-manager.multiple_delete');
    Route::put('pages-manager/toggle_status/{page}', [PagesManagerController::class, 'toggle_status'])->name('pages-manager.toggle_status');
    Route::resource('pages-manager', PagesManagerController::class)->parameter('pages-manager', 'page')->except(['show']);

    //Carousel
    Route::delete('carousel', [CarouselController::class, 'multiple_delete'])->name('carousel.multiple_delete');
    Route::put('carousel/toggle_status/{carousel}', [CarouselController::class, 'toggle_status'])->name('carousel.toggle_status');
    Route::put('carousel/reorder', [CarouselController::class, 'reorder'])->name('carousel.reorder');
    Route::resource('carousel', CarouselController::class)->except(['show']);

    //News
    Route::delete('news', [NewsController::class, 'multiple_delete'])->name('news.multiple_delete');
    Route::put('news/toggle_status/{news}', [NewsController::class, 'toggle_status'])->name('news.toggle_status');
    Route::resource('news', NewsController::class)->except(['show']);

    //Website Settings
    Route::controller(WebsiteSettingsController::class)->as('website-settings.')->group(function(){
        Route::get('website-settings', 'index')->name('index');
        Route::get('website-settings/{tab}', 'settings_tab_index')->name('tab');
        Route::put('website-settings/{tab}', 'settings_tab_save')->name('save');
    });

    //Subscriptions Managment
    Route::controller(SubscriptionsController::class)->as('subscriptions-management.')->group(function(){
        Route::get('subscriptions-management/{status?}', 'index')->name('index');
        Route::get('subscriptions-management/review/payment/{payment}', 'review_payment')->name('review-payment');
        Route::put('subscriptions-management/review/payment/{payment}/{status}', 'payment_status_action')->name('payment_status_action');
    });

    //Update
    Route::get('update/{v}', [UpdateController::class, 'update']);
});

//Artist Routes
Route::group(['middleware' => ['role:admin|artist', 'backend-check:subscribed']], function(){
    //Artworks
    Route::delete('artworks', [ArtworkController::class, 'multiple_delete'])->name('artworks.multiple_delete');
    Route::put('artworks/toggle_status/{artwork}', [ArtworkController::class, 'toggle_status'])->name('artworks.toggle_status');
    Route::get('artworks/messages/{artwork}', [ArtworkController::class, 'messages'])->name('artworks.messages');
    Route::resource('artworks', ArtworkController::class)->except(['show']);

    //Sponsors
    Route::delete('sponsors', [SponsorController::class, 'multiple_delete'])->name('sponsors.multiple_delete');
    Route::resource('sponsors', SponsorController::class)->except(['show']);

    //Sponsors
    Route::delete('exhibitions', [ExhibitionController::class, 'multiple_delete'])->name('exhibitions.multiple_delete');
    Route::resource('exhibitions', ExhibitionController::class)->except(['show']);

    //Blogs
    Route::delete('blogs', [BlogController::class, 'multiple_delete'])->name('blogs.multiple_delete');
    Route::put('blogs/toggle_status/{blog}', [BlogController::class, 'toggle_status'])->name('blogs.toggle_status');
    Route::resource('blogs', BlogController::class)->except(['show']);
});

Route::group(['middleware' => ['role:admin|store', 'backend-check:subscribed']], function(){
        //Categories
        Route::delete('categories', [CategoryController::class, 'multiple_delete'])->name('categories.multiple_delete');
        Route::resource('categories', CategoryController::class)->except(['show']);

        //Products
        Route::delete('products', [ProductController::class, 'multiple_delete'])->name('products.multiple_delete');
        Route::get('products/messages/{product}', [ProductController::class, 'messages'])->name('products.messages');
        Route::resource('products', ProductController::class)->except(['show']);
});

Route::middleware('role:artist|store')->group(function(){
    Route::get('subscription', [SubscriptionController::class, 'index'])->name('subscription.index');
    Route::get('subscription/payments/history', [SubscriptionController::class, 'payment_history'])->name('subscription.payment_history');
    Route::post('subscription/upgrade_plan', [SubscriptionController::class, 'upgrade_plan'])->name('subscription.upgrade_plan');
    Route::post('subscription/renew_plan', [SubscriptionController::class, 'renew_plan'])->name('subscription.renew_plan');
});

//Notifications
Route::prefix('notifications')->as('notifications.')->controller(NotificationsController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('stats', 'getNotificationsData')->name('stats');
    Route::get('mark-all-as-read', 'markAllAsRead')->name('mark-all-as-read');
    Route::get('{notification}', 'redirect')->name('redirect');
});

//
Route::controller(AccountController::class)->prefix('account')->as('account.')->group(function(){
    Route::get('my-profile', 'profile')->name('profile');
    Route::get('password', 'password')->name('password');
    Route::get('artist-profile', 'artist_profile')->middleware('role:artist')->name('artist_profile');
    Route::put('save/{tab}', 'save')->name('save');
});

Route::controller(SupportTicketController::class)->as('support_tickets.')->prefix('support/tickets')->group(function(){
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::get('/create', 'create')->name('create');
    Route::get('/{support_ticket}', 'show')->name('show');
    Route::post('/{support_ticket}', 'send_message')->name('send_message');
    Route::put('/{support_ticket}/close', 'close_ticket')->name('close_ticket');

});

//Upload
Route::post('upload', [UploadFilesController::class, 'upload'])->name('upload');
