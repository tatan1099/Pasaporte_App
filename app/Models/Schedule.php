<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Places;

class Schedule extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'hour_start',
        'hour_end',
        "day",
    ];


    public function place(){
        return $this->hasMany(Places::class,'schedule_id'); 
    }
}
