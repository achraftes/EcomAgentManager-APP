<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
     'category',
        'price'
    ];

    public function mediaBuyers()
    {
        return $this->belongsToMany(MediaBuyer::class, 'media_buyer_product');
    }
}

