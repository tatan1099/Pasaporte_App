<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Stand;
use App\Models\Passport;
use Carbon\Carbon;
use App\Service\AuthService;
use Illuminate\Support\Facades\Auth;
use TCPDF;
use App\Models\Table_qr;
use BaconQrCode\Encoder\QrCode;
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Writer;

class QRController extends Controller
{
    public function showScanner()
    {
        
        return view('qr.scanner');
    }
    
    
    public function guardarEscaneo($id)
     {
       
        if (Auth::user()->hasRole('Visitante')) {
            // Obtener el ID del stand desde la solicitud
            $stand = Stand::find($id);
    
            // Verificar si ya existe un registro para este usuario y stand
            $existingPassport = Passport::where('user_id', Auth::id())->where('stand_id', $id)->first();
    
            // Si no existe un registro, crear uno nuevo
            if (!$existingPassport) {
                // Crear un nuevo registro en la tabla de pasaportes
                Passport::create([
                    'date' => Carbon::now()->toDateString(),
                    'time' => Carbon::now()->toTimeString(),
                    'user_id' => Auth::id(), // Obtener el ID del usuario autenticado
                    'stand_id' => $id // Utilizar el ID del stand
                ]);
    
            }
        }
   
       
    }


    public function generarCodigoQR($standId)
    {
 
        $url = route('stands.show', $standId);

        // Crear un nuevo objeto TCPDF
        $pdf = new TCPDF();
        
        // Agregar una nueva página
        $pdf->AddPage();
        
        // Establecer el tamaño de la imagen del código QR
        $size = 150;
        
        // Generar el código QR y agregarlo al PDF
        $pdf->write2DBarcode($url, 'QRCODE,H', 15, 15, $size, $size);

        // Salida del PDF como imagen PNG
        $imageData = $pdf->Output('qrcode.png', 'I');
      
     
        

        // Devuelve una vista con el código QR
        return view('codigo_qr', compact('codigoQR', 'ID'));

    }
    
   
    
   
}   

