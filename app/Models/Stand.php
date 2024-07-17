<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stand extends Model
{
    use HasFactory;

    public $timestamps = false;

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
        'qr_code',
        'user_id',
        'color_contenedor_1', // Nuevo campo para el primer color del contenedor
        'color_contenedor_2',
        'images1',
        'images2',
        'images3',
        'images4',
        'images5',
        'images6',
        'images7',
        'images8',
        'images9',
        'images10', 
        'color_contenedor_3',
        'color_contenedor_4',
        'evento_id',
        'places_id',
    ];
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

        // En el modelo Stand.php
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'stand_id', 'id');
    }

    public function pasaportes()
    {
        return $this->hasMany(Passport::class,'stand_id','id');
    }
    public function event()
    {
        return $this->belongsTo(Event::class,'evento_id','id');
    }
    public function places()
    {
        return $this->belongsTo(Places::class,'places_id','id');
    }
    public function classifications()
    {
        return $this->belongsToMany(Classification::class, 'stand_has_classifications', 'stand_id', 'classification_id');
    }


    
}
