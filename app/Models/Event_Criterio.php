<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_Criterio extends Model
{
    use HasFactory;
    protected $table = 'event_criterio';
    protected $fillable = [
        'evento_id',
        'criterio_id',
    ];
    public function criterio()
    {
        return $this->belongsTo(Criterio::class, 'criterio_id');
    }
    public function evento()
    {
        return $this->belongsTo(Event::class);
    }
}
