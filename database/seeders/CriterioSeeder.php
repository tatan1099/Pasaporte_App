<?php

namespace Database\Seeders;

use App\Models\Criterio;
use Illuminate\Database\Seeder;

class CriterioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Criterio::create([
            'name' => 'Criterio 1',
            'description' => '1. De acuerdo a la exhibición que acaba de visitar, por favor califique el impacto visual que le generó donde cinco es muy bueno, cuatro es está bien, tres es me gusta, dos es debe mejorar y uno es no generó ningún impacto.'
        ]);
        Criterio::create([
            'name' => 'Criterio 2',
            'description' => '2. De acuerdo a lo que logró interpretar de la exhibición vista, ¿qué tantos materiales ecológicos o procesos de recirculación de materia prima logró evidenciar?.  Por favor responda en un rango entre 5 y 1, donde cinco es tiene varios, cuatro es algunos, tres es pocos, dos es se aprecia algo y 1 es no presenta ninguno.'
        ]);
        Criterio::create([
            'name' => 'Criterio 3',
            'description' => '3. La exhibición y los productos que que están en ella, a su criterio ,considera que presenta aspectos creativos, innovadores o conceptos diferentes.  Por ello, le pedimos el favor que entre un rango de 5 y 1 nos retroalimente, donde 5 es presenta algo muy novedoso, 4 es tiene algunos aspectos llamativos, 3 es no considero que sea tan innovadora más si llamativa, 2 es no es fácil identificar aspectos y 1 es no encuentro nada innovador o diferente.'
        ]);
    }
}
