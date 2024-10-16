<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Geography extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'countryCode', 'countryName', 'destinationId', 'destinationName', 'cityId', 'cityName'
    ];
}
