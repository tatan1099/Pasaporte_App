<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place_event extends Model
{
    use HasFactory;

    protected $table = 'place_event';
    protected $fillable = [
        'event_id',
        'place_id',
        
        
    ];

    public function event()
    {
        return $this->belongsTo('App\Models\Event', 'event_id');
    }

    public function place()
    {
        return $this->belongsTo('App\Models\Places', 'place_id');
    }
}