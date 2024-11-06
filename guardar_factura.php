<?php
// Datos de conexión
$servername = "localhost";
$username = "root"; // Usuario predeterminado de MySQL
$password = ""; // Contraseña en blanco (si no la cambiaste)
$dbname = "facturacion"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    echo "Conectado exitosamente";
}

// Obtener datos del formulario
$cliente = $_POST['cliente'];
$cedula = $_POST['cedula'];
$telefono = $_POST['telefono'];
$fecha = $_POST['fecha'];
$correo = $_POST['correo'];
$placa = $_POST['placa'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$anio = $_POST['anio'];
$chasis = $_POST['chasis'];

// Paso 1: Crear la factura y obtener el ID generado
$sql_factura = "INSERT INTO facturas (fecha) VALUES ('$fecha')";

if ($conn->query($sql_factura) === TRUE) {
    $factura_id = $conn->insert_id; // Obtener el ID de la factura creada

    // Paso 2: Insertar datos en la tabla `clientes`
    $sql_cliente = "INSERT INTO clientes (cliente, cedula, telefono, correo, factura_id) 
                    VALUES ('$cliente', '$cedula', '$telefono', '$correo', '$factura_id')";

    if ($conn->query($sql_cliente) === TRUE) {
        $cliente_id = $conn->insert_id; // Obtener el ID del cliente recién insertado

        // Paso 3: Insertar datos en la tabla `vehiculos` asociados al cliente
        $sql_vehiculo = "INSERT INTO vehiculos (cliente_id, placa, marca, modelo, anio, chasis) 
                         VALUES ('$cliente_id', '$placa', '$marca', '$modelo', '$anio', '$chasis')";

        if ($conn->query($sql_vehiculo) === TRUE) {
            // Información del vehículo que deseas mostrar en el QR
            require 'phpqrcode/qrlib.php'; // Incluye la biblioteca phpqrcode

            $infoVehiculo = "Placa: $placa\nMarca: $marca\nModelo: $modelo\nAño: $anio\nChasis: $chasis";

            // Ruta para guardar el QR temporalmente
            $filename = 'qr_temp.png';
            QRcode::png($infoVehiculo, $filename); // Genera el QR y guárdalo

            // Redirigir a la página de impresión
            header("Location: imprimir.php?factura_id=" . $factura_id);
            exit();
        } else {
            echo "Error al guardar el vehículo: " . $conn->error;
        }
    } else {
        echo "Error al guardar el cliente: " . $conn->error;
    }
} else {
    echo "Error al crear la factura: " . $conn->error;
}

// Cerrar conexión
$conn->close();
?>
