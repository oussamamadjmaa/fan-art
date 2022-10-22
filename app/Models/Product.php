<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'price',
        'description',
        'image',
    ];

    /**
     * Relations
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function messages(){
        return $this->morphMany(Message::class, 'messageable');
    }

    public function notifications(){
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function visits(){
        return $this->morphMany(Visit::class, 'visitable');
    }

    /**
     * Append attributes
     */
    public function getPriceAttribute($price){
        $this->append('price_format');
        return $price;
    }

    public function getPriceFormatAttribute(){
        return price_format($this->price);
    }

    /**
     * Functions
     */
    public function hasMessageFromThisSender(){
        return $this->messages()->when(auth()->check(),
                                        fn($q) => $q->where('sender_type', 'App\Models\User')->where('sender_id', auth()->id()),
                                        fn($q) => $q->where('data->ip_address', request()->ip()))
                                        ->count();
    }
}
