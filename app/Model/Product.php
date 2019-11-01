<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'detail', 'price', 'qty', 'discount', 'user_id'
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
