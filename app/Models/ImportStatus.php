<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportStatus extends Model
{
    use HasFactory;
      // Ajoutez les attributs que vous souhaitez pouvoir assigner en masse
      protected $fillable = [
        'file_name',
        'status',
    ];
}