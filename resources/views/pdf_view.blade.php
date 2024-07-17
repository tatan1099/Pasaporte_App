<!DOCTYPE html>
<html>
<head>
    <title>PDF con código QR</title>
</head>
<body>
    <h1>PDF con código QR</h1>
    <img src="data:image/png;base64,{{ base64_encode($pdfContent) }}" alt="Código QR">
</body>
</html>