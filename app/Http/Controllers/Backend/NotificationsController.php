<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Meta;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use stdClass;

class NotificationsController extends Controller
{
    public function index()
    {
        $meta = new Meta(['title' => __('Notifications')]);
        $unread_count = auth()->user()->notifications()->unseen()->limit(1)->count();

        if(request()->expectsJson()){
            $notificationsDB = auth()->user()->notifications()->with(['notifiable', 'from_user'])->latest('id')->cursorPaginate(15)->withQueryString();
            $notifications = json_decode(NotificationResource::collection($notificationsDB)->toJson());

            $slot = array_merge($notificationsDB->toArray(), ['data' => view('Backend.Notifications.list', compact('notifications'))->render()]);

            return response()->json($slot);
        }
        return view('Backend.Notifications.index', compact('unread_count'));
    }

    public function getNotificationsData()
    {
        abort_if(!request()->expectsJson(), 404);

        $data = new stdClass();

        $data->unread_count = auth()->user()->notifications()->unseen()->limit(10)->count();
        $data->unread_count = ($data->unread_count == 10) ? "+9" : $data->unread_count;

        $notificationsDB = auth()->user()->notifications()->with(['notifiable', 'from_user'])->latest()->limit(10)->get();
        $data->notifications = json_decode(NotificationResource::collection($notificationsDB)->toJson());

        return response()->json($data);
    }

    public function redirect(Notification $notification){
        abort_if($notification->to_user_id != auth()->id(), 404);

        $url = (request()->get('b') == true) ? false : route('backend.notifications.index');

        $routes = [];
        $routes['artworks.new_message'] =  route('backend.artworks.messages', $notification->notifiable_id);
        $routes['orders.new_artwork_order'] =  route('backend.orders.index', $notification->notifiable_id);
        $routes['orders.hotel_artworks_order'] =  route('backend.hotels-artworks-orders.index', $notification->notifiable_id);
        $routes['products.new_message'] =  route('backend.products.messages', $notification->notifiable_id);
        $routes['support_tickets.new_ticket'] = $routes['support_tickets.new_message']  = $routes['support_tickets.ticket_closed'] =  route('backend.support_tickets.show', $notification->notifiable_id);
        $routes['subscription.new_pending_payment'] =  route('backend.subscriptions-management.review-payment', $notification->notifiable_id);
        $routes['subscription.payment_confirmed'] = $routes['subscription.payment_declined'] =  route('backend.subscription.payment_history');

        $url = $routes[$notification->type] ?? $url;

        $notification->markAsRead();
        return $url ? redirect($url) : redirect()->back();
    }

    public function markAllAsRead(){
        auth()->user()->notifications()->unseen()->update(['seen_at' => now()]);
        return redirect()->route('backend.notifications.index');
    }

}
