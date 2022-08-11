<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    const PUBLISHED = 1;

    protected $fillable = [
        'user_id',
        'slug',
        'title',
        'image',
        'image_description',
        'body',
        'seo',
        'status'
    ];

    protected $casts = [
        'seo' => 'array',
        'status' => 'boolean'
    ];

    /**
     * Relations
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Scopes
     */
    public function scopePublished($q){
        return $q->whereStatus(self::PUBLISHED);
    }

    /**
     * Functions
     */
    public function generateSlug($title)
    {
        $slug = slugme($title);
        if (static::whereSlug($slug)->exists()) {
            $max = static::whereTitle($title)->latest('id')->skip(1)->value('slug');
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
