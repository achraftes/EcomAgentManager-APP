<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaBuyer extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name', 'email', 'products', 'source',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'media_buyer_product');
    }
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
