<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = [
        'latitud',
        'longitud',
        // Otros campos si los necesitas
    ];
}
