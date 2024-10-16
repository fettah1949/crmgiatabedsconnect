<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
      
    protected $fillable = [
        
        'Hotel_Code',
        'giataId',
        'Hotel_Name',
        'Latitude',
        'Longitude',
        'addresses',
        'City',
        'Zip_Code',
        'Email',
        'Country',
        'phones_voice',
        'phones_fax',
        'chainId',
        'chainName',
      
    ];
}
