<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //C:\adso_git\proyecto_tecnoparque\proyectoTpc\public\multimedia\videos
        $localGifPath = public_path('\multimedia\videos\Animación_sello_gif.gif');


        if (file_exists($localGifPath)) {
            // Almacenar el archivo en storage/public/videos
            $path = Storage::putFileAs('public/videos', $localGifPath, 'Animación_sello_gif.gif');
        
            // Output para informar sobre la ruta del GIF almacenado
            echo 'GIF almacenado en: ' . Storage::url($path);
        } else {
            // El archivo local no existe
            echo 'El archivo local no existe.';
        }
    }
}
