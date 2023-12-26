<?php
date_default_timezone_set('America/Bogota');
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../../../../../index.php");
    exit();
}

// Incluye la configuración de conexión a la base de datos
require_once '../../../../controllers/conexion.php';

// El usuario está autenticado, obtén el ID del usuario de la sesión
$usuario_id = $_SESSION["usuario_id"];

$sql_nombre = "SELECT nombre FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql_nombre);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
if ($fila = $resultado->fetch_assoc()) {
    $_SESSION["nombre_usuario"] = $fila["nombre"];
}
$stmt->close();

// Preparar la consulta para obtener el rol del usuario
$stmt = $conexion->prepare("SELECT roles.Nombre FROM usuarios INNER JOIN roles ON usuarios.RolID = roles.ID WHERE usuarios.ID = ?");
$stmt->bind_param("i", $usuario_id);

// Ejecutar la consulta
$stmt->execute();
$resultado = $stmt->get_result();
$fila = $resultado->fetch_assoc();

$stmt->close();

// Verifica si el resultado es nulo o si el rol del usuario no es 'admin'
if (!$fila || $fila['Nombre'] !== 'Superadmin') {
    header("Location: /ruta_a_pagina_de_error_o_inicio.php");
    exit();
}


// Función para obtener la suma de una columna de una tabla
function obtenerSuma($conexion, $tabla, $columna)
{
    $sql = "SELECT SUM($columna) AS Total FROM $tabla";
    $resultado = mysqli_query($conexion, $sql);
    if ($resultado) {
        $fila = mysqli_fetch_assoc($resultado);
        mysqli_free_result($resultado);
        return $fila['Total'] ?? 0; // Devuelve 0 si es null
    } else {
        echo "Error en la consulta: " . mysqli_error($conexion);
        return 0;
    }
}

// Obtener los totales
$totalMonto = obtenerSuma($conexion, "prestamos", "MontoAPagar");
$totalIngresos = obtenerSuma($conexion, "historial_pagos", "MontoPagado");
$totalComisiones = obtenerSuma($conexion, "prestamos", "Comision");
date_default_timezone_set('America/Bogota');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Admin</title>

    <link rel="stylesheet" href="/public/assets/css/inicio.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>

</head>





<main>
    <h1>Inicio Administrador</h1>
    <div class="cuadros-container">











        <div class="cuadro cuadro-2">
            <div class="cuadro-1-1">
                <a href="/resources/views/admin/superadmin/apagarSis/apagarSist.php" class="titulo">Apagar Sistema </a>
            </div>
        </div>






    </div>


    </div>
    </div>


</main>






</body>

</html>