<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Schedule;
use App\Models\Agenda;

class Places extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        "address",
        'latitude',
        'length',
        'schedule_id',
    ];

    public function agenda(){
        return $this->hasMany(Agenda::class, 'place_id');
    }

    public function schedule(){
        return $this->belongsTo(Schedule::class,'schedule_id'); 
    }
    

}
