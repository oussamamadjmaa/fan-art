<?php

namespace App\Notifications;

use App\Http\Resources\NotificationResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Notification as NotificationModel;

class NotifyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $notification_;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(NotificationModel $notification_)
    {
        $this->notification_ = json_decode(NotificationResource::make($notification_)->toJson());
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $notification = $this->notification_;
        return (new MailMessage)->subject($this->notification_->title)
        //{{ route('backend.notifications.redirect', $notification->id) }}
        ;
    }

}
