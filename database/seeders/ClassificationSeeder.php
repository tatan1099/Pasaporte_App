<?php

namespace Database\Seeders;

use App\Models\Classification;
use Illuminate\Database\Seeder;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Classification::create(['name' => 'Moda Sostenible']);
        Classification::create(['name' => 'Proyectos ITO']);
        Classification::create(['name' => 'Gastronomía']);
        Classification::create(['name' => 'Construcción']);
        Classification::create(['name' => 'Biotecnología - Bioeconomía']);
        Classification::create(['name' => 'Agroindustria']);
        Classification::create(['name' => 'Otras']);
        Classification::create(['name' => 'Economía Popular']);
    }
}
