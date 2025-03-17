<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel_provider extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'hotel_code',
        'giataId',
        'provider_name',
        'provider_code',
    ];
}
