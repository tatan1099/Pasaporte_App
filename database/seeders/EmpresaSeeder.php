<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => "Bavaria",
            'email' => "bavaria@gmail.com",
            'document'=>'1234568',
            'password' => bcrypt('12345678'),
            'phone_number'=>'3215678991',
            'rol_id'=> 3
        ]);
        $user->assignRole('Empresa');
    }
    
}