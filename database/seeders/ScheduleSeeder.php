<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schedule::create([
            'id' => 1,
            'day'=> "Horario Regular",
            'hour_start'=>'10:00:00',
            'hour_end'=>'20:00:00',
        ]);
        Schedule::create([
            'id' => 2,
            'day'=> "Horario Extendido",
            'hour_start'=>'10:00:00',
            'hour_end'=>'21:00:00',
        ]);
    }
}
