<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'sender_type', 'messageable_id', 'messageable_type', 'body', 'data', 'seen_at'];

    protected $casts = ['data' => 'object', 'seen_at' => 'datetime'];

    //Sender
    public function sender() : MorphTo{
        return $this->morphTo(__FUNCTION__, 'sender_type', 'sender_id');
    }

    //Messageable
    public function messageable() : MorphTo{
        return $this->morphTo();
    }

    //
    public function notifications(){
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
