<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
      
    protected $fillable = [
        'hotel_code',
        'hotel_name',
        'provider_id',
        'provider',
        'bdc_id',
        'country',
        'city',
        'giataId',
        'country_code',
        'CityCode',
        'addresses',
        'phones_voice',
        'phones_fax',
        'email',
        'latitude',
        'longitude',
        'chainId',
        'chainName',
        'zip_code',
        'CategoryCode',
        'CategoryName',
        'status',
        'with_giata',
      
    ];
}
