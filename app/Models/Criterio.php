<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterio extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name', 'description'
    ];

    public function evaluations(){
        return $this->hasMany(Evaluation::class, 'criterios_id', 'id');
    }
}
