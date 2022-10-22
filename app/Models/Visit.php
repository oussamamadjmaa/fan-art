<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = ['visitable_id', 'visitable_type', 'count','visits_date'];

    protected $casts = ['visits_date' => 'datetime:Y-m-d'];

    //Sender
    public function sender() : MorphTo{
        return $this->morphTo(__FUNCTION__, 'sender_type', 'sender_id');
    }

    //Messageable
    public function visitable() : MorphTo{
        return $this->morphTo();
    }
}
