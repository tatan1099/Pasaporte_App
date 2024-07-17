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
    <script>
        document.querySelector('button').addEventListener('click', function () {
            var ID = document.querySelector('#standId').innerText;

            // Envía los datos del formulario al servidor para generar el PDF
            fetch('{{ url('/imprimirqr') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    ID: ID
                })
            })
            .then(response => {
                // Verificar si la respuesta es correcta (código de estado 200)
                if (response.ok) {
                    // Convertir la respuesta a un blob (archivo binario)
                    return response.blob();
                } else {
                    throw new Error('Error al generar el PDF');
                }
            })
            .then(blob => {
                // Crear una URL del blob para el PDF
                const url = URL.createObjectURL(blob);

                // Abrir el PDF en una nueva pestaña del navegador
                window.open(url, '_blank');
            })
            .catch(error => {
                console.error('Erro r al generar el PDF:', error);
            });
        });
    </script>
    
</body>

</html>