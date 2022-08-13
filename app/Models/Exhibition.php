<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sponsor_id',
        'name',
        'from_date',
        'to_date',
        'country',
        'city',
        'registration_url'
    ];

    protected $casts = [
        'from_date' => 'date:Y-m-d',
        'to_date'   => 'date:Y-m-d'
    ];

    /**
     * Model Relations
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sponsor(){
        return $this->belongsTo(Sponsor::class);
    }



    /**
     * Functions
     */
    public function generateSlug($name, $id = false)
    {
        $slug = slugme($name);
        if (static::whereSlug($slug)->where('id', '!=', $id)->exists()) {
            $max = static::whereName($name)->skip(1)->value('slug');
            if (isset($max[-1]) && is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$slug}-2";
        }

        return $slug;
    }

}
