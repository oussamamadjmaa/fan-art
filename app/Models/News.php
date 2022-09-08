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

    public function visits(){
        return $this->morphMany(Visit::class, 'visitable');
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
    public function generateSlug($title, $id = false, $slug_suffix = '')
    {
        $slug = slugme($title.$slug_suffix);
        if (static::whereSlug($slug)->where('id', '!=', $id)->exists()) {
            return static::generateSlug($title , $id, "-".mt_rand(2, 999));
        }
        return $slug;
    }
}
