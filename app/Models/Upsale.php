<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upsale extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'produit',
        'prix',
        'quantite'
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
