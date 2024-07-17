<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Places;
use App\Models\Stand;

class Agenda extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'date_start',
        'date_end',
        'place_id',
        'stand_id'
    ];


    public function place(){
        return $this->belongsTo(Places::class, 'place_id');
    }

    public function stand(){
        return $this->belongsTo(Stand::class, 'stand_id');
    }
}
