<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\admin;
use App\Models\Stand;
use App\Models\visitante;
use App\Models\Passport;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public $timestamps = false;

    ///para definir la relaciòn entre el modelo de evento 
    public function eventos()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'document',
        'email',
        'password',
        "address",
        'phone_number',
        "birthday",
        "genere",
        'rol_id',
        'auth_id',
        'auth_name',
        'multi_evento',
        'age',
        'Empresa_verificada'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function passports(){
        return $this->hasMany(Passport::class, 'id', 'id');
    }

    public function rol(){
        return $this->belongsTo(Rol::class,'rol_id'); 
    }

}
