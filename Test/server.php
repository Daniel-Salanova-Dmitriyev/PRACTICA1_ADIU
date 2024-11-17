<?php
include 'config.php'; // Asegúrate de incluir el archivo de configuración

global $conn;

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

header('Content-Type: application/json');

// Consulta para obtener pedidos por nacionalidad
$consultaNacionalidad = "SELECT zonageografica.zog_nombre AS Continente, pais.pai_nombre AS Nacionalidad, COUNT(pedido.ped_id) AS TotalPedidos
FROM pedido
JOIN domicilio ON pedido.ped_dom_id = domicilio.dom_id
JOIN calle ON domicilio.dom_cal_id = calle.cal_id
JOIN ciudad ON calle.cal_ciu_id = ciudad.ciu_id
JOIN pais ON ciudad.ciu_pai_id = pais.pai_id    
JOIN zonageografica ON pais.pai_zog_id = zonageografica.zog_id
GROUP BY pais.pai_nombre;";

$pedidosNacionalidad = mysqli_query($conn, $consultaNacionalidad);

if (!$pedidosNacionalidad) {
    die(json_encode(["error" => "Error en la consulta de nacionalidad: " . mysqli_error($conn)]));
}

// Consulta para obtener pedidos por ciudad
$consultaCiudad = "SELECT ciudad.ciu_nombre AS Ciudad, COUNT(pedido.ped_id) AS TotalPedidos
FROM pedido
JOIN domicilio ON pedido.ped_dom_id = domicilio.dom_id
JOIN calle ON domicilio.dom_cal_id = calle.cal_id
JOIN ciudad ON calle.cal_ciu_id = ciudad.ciu_id
GROUP BY ciudad.ciu_nombre;";

$pedidosCiudad = mysqli_query($conn, $consultaCiudad);

if (!$pedidosCiudad) {
    die(json_encode(["error" => "Error en la consulta de ciudad: " . mysqli_error($conn)]));
}

// Almacenar resultados en arrays separados
$resultadoNacionalidad = [];
while ($pedido = mysqli_fetch_assoc($pedidosNacionalidad)) {
    $resultadoNacionalidad[] = $pedido;
}

$resultadoCiudad = [];
while ($pedido = mysqli_fetch_assoc($pedidosCiudad)) {
    $resultadoCiudad[] = $pedido;
}

// Enviar los datos como un único JSON con ambos conjuntos de resultados
echo json_encode([
    "nacionalidad" => $resultadoNacionalidad,
    "ciudad" => $resultadoCiudad
]);

// Cerrar la conexión
$conn->close();
?>
