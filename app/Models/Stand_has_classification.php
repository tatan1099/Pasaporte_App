<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stand_has_classification extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'stand_id',
        'classification_id'
    ];

    public function stand(){
        return $this->belongsTo(Stand::class, 'stand_id', 'id');
    }

    public function classification(){
        return $this->belongsTo(Classification::class, 'classification_id', 'id');
    }
}
