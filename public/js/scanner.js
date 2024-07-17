$(document).ready(function () {
    var scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

    $('#scanQR').click(function () {
        $('#imagenEscaneo').hide();
        $('#qrVideo').show();

        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);

                scanner.addListener('scan', function (content) {
                    $('#qrResult').text('Resultado: ' + content);
                    window.location.href = content;
                    scanner.stop();
                });
            } else {
                console.error('No se encontraron cámaras en el dispositivo.');
            }
        }).catch(function (e) {
            console.error('Error al acceder a las cámaras:', e);
        });
    });
});