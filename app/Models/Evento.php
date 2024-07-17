<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'banner',
        'description',
        'facebook',
        'instagram',
        'tiktok',
        'web',
        'calification',
        'start_date',
        'end_date',
        'user_id',
        'start_hour',
        'end_hour',
        
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
