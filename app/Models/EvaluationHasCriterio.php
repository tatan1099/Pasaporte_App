<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationHasCriterio extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'evaluation_id',
        'criterio_id',
        'rankCriterio'
    ];

    public function evaluation(){
        return $this->belongsTo(Evaluation::class, 'evaluation_id', 'id');
    }

    public function criterio(){
        return $this->belongsTo(Criterio::class, 'criterio_id', 'id');
    }
}
