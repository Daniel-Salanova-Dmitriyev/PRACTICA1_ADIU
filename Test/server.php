<?php
include 'config.php'; // Asegúrate de incluir el archivo de configuración

global $conn;

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
// Verifica la conexión
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

header('Content-Type: application/json');

// Consulta para obtener todas las reservas
$consulta = "SELECT 
    tipo_hab.denominacion AS tipo_habitacion, 
    COUNT(habitacion.codigo) AS total_tipo_hab 
FROM 
    habitacion 
JOIN 
    tipo_hab ON habitacion.codigo = tipo_hab.codigo 
GROUP BY 
    tipo_hab.codigo;";

$reservas = mysqli_query($conn, $consulta);

// Verifica si la consulta se ejecutó correctamente
if (!$reservas) {
    die(json_encode(["error" => "Error en la consulta: " . mysqli_error($conn)]));
}

// Crear un array para almacenar los resultados
$resultado = [];
while ($reserva = mysqli_fetch_assoc($reservas)) {
    $resultado[] = $reserva;  // Agregar cada fila al array
}

// Codificar en JSON y enviar como respuesta
echo json_encode($resultado);

// Cerrar la conexión
$conn->close();
?>