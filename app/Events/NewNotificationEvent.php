<?php

namespace App\Events;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewNotificationEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;
    public $stats;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notification)
    {
        $notification_ = new NotificationResource($notification);
        $this->notification = json_decode($notification_->toJson());

        //Receiver Stats
        $notifications_count = Notification::where('to_user_id', $notification->to_user_id)->unseen()->limit(10)->count();
        $this->stats = [
            'notifications_count' =>  $notifications_count > 9 ? '+9' : $notifications_count
        ];
    }

    public function broadcastAs()
    {
        return 'notification.new';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notifications.'.$this->notification->to_user_id);
    }
}
