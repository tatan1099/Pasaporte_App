<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => "Andres Q",
            'email' => "andres@gmail.com",
            'document'=>'1234',
            'password' => bcrypt('12345678'),
            'phone_number'=>'3215678991',
            'rol_id'=> 2
        ]);
        $user->assignRole('Visitante');
    }
}
