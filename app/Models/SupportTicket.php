<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    const OPENED = 0;
    const CLOSED = 1;

    protected $fillable = [
        'user_id',
        'subject',
        'status'
    ];


    /**
     * Relations
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function messages(){
        return $this->morphMany(Message::class, 'messageable');
    }

    public function last_message(){
        return $this->morphOne(Message::class, 'messageable')->latest();
    }

    public function notifications(){
        return $this->morphMany(Notification::class, 'notifiable');
    }

    /**
     * Attributes
     */
    public function getStatusAttribute($status){
        $this->append('status_text');
        return $status;
    }

    public function getStatusTextAttribute(){
        $text = 'Unknown';
        switch ($this->status) {
            case self::OPENED:
                $text = 'Opened';
                break;
            case self::CLOSED:
                $text = 'Closed';
                break;
        }
        return __($text);
    }
}
