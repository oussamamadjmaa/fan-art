<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value'
    ];

    protected $casts = [
        'value' => 'array',
    ];

    protected static function boot(){
        parent::boot();

        self::created(function($config){
            Cache::forget('db_config');
        });

        self::updated(function($config){
            Cache::forget('db_config');
        });

        self::deleted(function($config){
            Cache::forget('db_config');
        });
    }
}
