<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Stand;

class Passport extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'passports';

    protected $fillable = [
        'date',
        'user_id',
        'stand_id',
        'time'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function stand(){
        return $this->belongsTo(Stand::class, 'stand_id');
    }
}



