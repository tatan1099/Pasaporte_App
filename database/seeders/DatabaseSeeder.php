<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();->No descomentar xD
        $this->call(RolSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(VisitorSeeder::class);
        $this->call(ClassificationSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(EmpresaSeeder::class);
        $this->call(VideoSeeder::class);
        $this->call(StandSeeder::class);
        $this->call(CriterioSeeder::class);
        $this->call(PlaceSeeder::class);
        $this->call(StandSeeder::class);
    }
}
