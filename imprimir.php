<?php
// Conéctate a la base de datos y recupera la información
$factura_id = $_GET['factura_id'];

// Recuperar datos de cliente, vehículo y monto aquí
// ...

// Mostrar datos
?>
<!DOCTYPE html>
<html>
<head>
    <title>Factura - Imprimir</title>
    
</head>

<body>
    <h1>Factura ID: <?php echo $factura_id; ?></h1>
    <p><strong>Cliente:</strong> <?php echo $cliente; ?></p>
    <p><strong>Monto:</strong> RD$ <?php echo $monto; ?></p>
    <!-- Agregar más datos aquí -->

    <h3>QR con información del vehículo:</h3>
    <img src="qr_temp.png" alt="Código QR">
    <button onclick="window.print()">Imprimir</button>
    
</body>
</html>

