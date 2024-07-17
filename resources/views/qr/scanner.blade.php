@extends('layouts.app')

@section('content')
<div class="container-fluid adminQR py-4">
    <div class="caja-admin-QR">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 text-center">
                <div class="mb-4">
                    <img class="logo-detallesrelacionadosalstandqr mx-auto img-fluid" src="{{ asset('images/logoStand.png') }}" alt="Logo Stand">
                </div>
                <p class="textQR1 red-textqr mb-2">Escanea y Comparte</p>
                <h2 class="textQR2 gris-textqr mb-4">Tu Opinión</h2>
                <div class="mb-4">
                    <img id="imagenEscaneo" class="imagenEscaneo img-fluid" src="{{ asset('images/scaneo.png') }}" alt="Escaneo" style="max-width: 150px;">
                </div>

                <div id="qrVideo" class="qrVideo video-container mb-4" style="display: none;">
                    <video id="preview" class="scannere w-100" playsinline="true"></video>
                </div>

                <div id="qrResult" class="qrResult mt-3"></div>
                
                <button id="scanQR" class="scanQR btn mt-4">Escanear Código QR</button>
                <br><br>
            </div>
        </div>
    </div>
</div>
@endsection
