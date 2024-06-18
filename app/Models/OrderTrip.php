<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTrip extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id', 
        'driver_id', 
        'status'
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
