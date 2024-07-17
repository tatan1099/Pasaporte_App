<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => "evento",
            'email' => "evento@gmail.com",
            'document'=>'12345',
            'password' => bcrypt('12345678'),
            'phone_number'=>'3215678991',
            'rol_id'=> 4
        ]);
        $user->assignRole('Evento');
    }
    
}