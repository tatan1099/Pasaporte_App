<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
//use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Stand;
use App\Models\Passport;
use Carbon\Carbon;
use App\Services\AuthService;
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
            $stand = Stand::find($id);
    
            if (!$stand) {
                return view('error')->with('error', 'Stand no encontrado',404);
            }
    
            $existingPassport = Passport::where('user_id', Auth::id())->where('stand_id', $id)->first();
    
            if (!$existingPassport) {
                try {
                    Passport::create([
                        'date' => Carbon::now()->toDateString(),
                        'time' => Carbon::now()->toTimeString(),
                        'user_id' => Auth::id(),
                        'stand_id' => $id
                    ]);
                } catch (\Exception $e) {
                    return view('error')->with('error', 'Error al guardar el escaneo');
                }
            }
    
            return view('error')->with('error', 'Escaneo guardado', 200);
        }
    
        return view('error')->with('error', 'Error al guardar el escaneo',403);

       
    }

    public function generarCodigoQR($standId)
    {
        $url = route('stands.show', $standId);

        // Crear un nuevo objeto TCPDF
        $pdf = new TCPDF();
        $pdf->SetTitle('QR');
        $pdf->setHeaderData('', 0, '', '', array(0, 0, 0), array(255, 255, 255));

        // Agregar una nueva página
        $pdf->AddPage();

        // Agregar la imagen del logo
        $pdf->Image(public_path('images/LOGO_QR.pdf'), 5, 5, 60, 60, '', '', 'T', false, 300, '', false, false, 1, false, false, false);

        // Establecer el tamaño de la imagen del código QR
        $size = 130;

        // Definir las coordenadas de la imagen del código QR
        $x = 40;
        $y = 70; // Cambia esta coordenada para ajustar la posición vertical

        // Generar el código QR y agregarlo al PDF
        $pdf->write2DBarcode($url, 'QRCODE,H', $x, $y, $size, $size);

        // Calcular el ancho disponible para la franja negra
        $availableWidth = $pdf->getPageWidth();

        // Calcular la altura disponible para la franja negra
        $availableHeight = $pdf->getPageHeight() - ($size + $y + 20);

        // Calcular las coordenadas de la franja negra
        $rectX = 0;
        $rectY = 220;

        // Agregar la franja negra debajo del código QR
        $pdf->SetFillColor(142, 36, 60); // Establecer el color de relleno en negro
        $pdf->Rect($rectX, $rectY, $availableWidth, $availableHeight, 'F'); // Dibujar un rectángulo negro debajo del código QR

        // Calcular las coordenadas y el tamaño para el texto "Escanea QR" centrado en la franja negra
        $textWidth = $availableWidth;
        $textHeight = 10;
        // Calcular las coordenadas y el tamaño para el texto "Escanea el QR" centrado en la franja negra
        $textX = $rectX;
        $textY = $rectY + ($availableHeight - $textHeight) / 2; // Centrar verticalmente el texto en la franja negra

        // Agregar el texto "Escanea el QR" centrado horizontal y verticalmente en la franja negra
        $pdf->SetFont('helvetica', '', 40);
        $pdf->SetTextColor(255, 255, 255); // Establecer el color del texto en blanco
        $pdf->SetXY($textX, $textY); // Establecer la posición para el texto
        $pdf->Cell($textWidth, $textHeight, 'Escanea el QR', 0, 0, 'C'); // Agregar el texto centrado en la franja negra




        // Salida del PDF como imagen PNG
        $imageData = $pdf->Output('qrcode.pdf', 'I');

        // Devuelve una vista con el código QR
        return view('codigo_qr', compact('codigoQR', 'ID'));
    }
}
