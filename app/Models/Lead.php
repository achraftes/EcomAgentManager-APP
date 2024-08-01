<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\MediaBuyer;
use App\Models\Agent;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'order_date',
        'total_charge',
        'client',
        'phone',
        'address',
        'product',
        'amount',
        'status',
        'media_buyer_id',
        'quantite',       
        'upsale',         
        'comment',
        'city',
        'agent_id'        // New field
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($lead) {
            Client::updateOrCreate(
                ['full_name' => $lead->client],
                [
                    'phone' => $lead->phone,
                    'email' => $lead->email,
                    'address' => $lead->address,
                ]
            );
        });
    }
    protected $casts = [
        'order_date' => 'datetime',
    ];
    public function mediaBuyer()
    {
        return $this->belongsTo(MediaBuyer::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id'); // Ensure it's defined correctly
    }
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
    public function upsales()
    {
        return $this->hasMany(Upsale::class);
    }
    public static function getStatuses()
    {
        return [
            'confirmed',
            'delivred',
            'no response',
            'canceled',
            'hors zone',
            'rdv',
            'doublant',
            'rappel',
            'non traite',
            'numero incorrect',
            'wtsp',
            'pas sur wtsp'
        ];
    }
}
