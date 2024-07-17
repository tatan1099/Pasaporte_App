<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Event extends Model
{
    use HasFactory;
    protected $table='event';
    protected $fillable = [
        'name',
        'logo',
        'banner',
        'description',
        'facebook',
        'instagram',
        'tiktok',
        'web',
        'calification',
        'start_date',
        'end_date',
        'start_hour',
        'end_hour',
        'user_id',
        'color_contenedor_1',
        'color_contenedor_2',
        'color_contenedor_3',
        'color_contenedor_4',
        'numero_imagenes',
        'images1',
        'images2',
        'images3',
        'images4',
        'images5',
        'images6',
        'images7',
        'images8',
       
    ];

    public function stands()
    {
        return $this->hasMany(Stand::class,'evento_id','id');
    }
   
}
