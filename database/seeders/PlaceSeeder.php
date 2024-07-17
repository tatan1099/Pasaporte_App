<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Places;


class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $place=Places::create([
            'name' => "CC Parque Caracoli",
            'email' => "caracoli@gmail.com",
            'address'=>'Carrera 27 # 29-145 Cañaveral autopista, Floridablanca, Santander',
            'latitude'=>'7.0716293103033205',
            'length'=> '-73.10543347067028',
            'schedule_id'=> 1,
        ]);
        $place=Places::create([
            'name' => "CC Parque Caracoli",
            'email' => "caracoli@gmail.com",
            'address'=>'Carrera 27 # 29-145 Cañaveral autopista, Floridablanca, Santander',
            'latitude'=>'7.0716293103033205',
            'length'=> '-73.10543347067028',
            'schedule_id'=> 2,
        ]);
    }
}
