<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table_qr extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'stand_id',
        'qr'
        
    
    ];
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function evaluations(){
        return $this->hasMany(Evaluation::class, 'stands_id', 'id');
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

    
}
