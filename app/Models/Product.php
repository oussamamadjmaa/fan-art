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
}
