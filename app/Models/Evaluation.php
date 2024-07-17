<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'rank',
        'feedback',
        'criterio_id',
        'stand_id',
        'user_id'
    ];

    public function criterio()
    {
        return $this->belongsTo(Criterio::class, 'criterio_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function stand()
{
    return $this->belongsTo(Stand::class, 'stand_id', 'id');
}
}
