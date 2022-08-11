<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    const ACTIVE = 1;

    /**
     * Fillable columns
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'title',
        'content',
        'seo',
        'status',
    ];

    /**
     * Casts
     *
     * @var array<string, string>
     */
    protected $casts = [
        'seo' => 'array',
        'status' => 'boolean',
    ];

    /**
     * Appends
     *
     * @var array<int, string>
     */
    protected $appends = ['link'];

    /**
     * Scopes
     */
    public function scopeActive($q){
        return $q->whereStatus(self::ACTIVE);
    }

    /**
     * Appended Attributes
     */
    public function getLinkAttribute(){
        return route('frontend.page', $this->slug);
    }
}
