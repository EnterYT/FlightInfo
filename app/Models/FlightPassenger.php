<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightPassenger extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'month',
        'category',
        'passenger_count',
    ];
}
