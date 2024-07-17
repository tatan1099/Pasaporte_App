<!DOCTYPE html>
<html>
<head>
    <title>Código QR</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="http://127.0.0.1:8000/css/styles.css">
</head>
<body>
    <main class="ticket-system">
        <div class="top">
            <h1 class="title">Scanea el código QR</h1>

            <div class="contenedor-ticket">
                <div class="printer"></div>
                <div class="receipts-wrapper">
                    <div class="receipts">
                        <div class="receipt">
                            <div class="">
                                <div class="description">
                                    <div class="qr-container">
                                        <div class="ticket">
                                            <div id="qrCodeImg" src="{{ $codigoQR }}">

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label id="standId">{{$ID}}</label>
                        </div>
                        <div>
                            <button type="button">Generar PDF</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- JavaScript para generar el PDF -->
    
</body>

</html>