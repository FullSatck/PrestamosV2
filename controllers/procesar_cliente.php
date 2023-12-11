<?php
// Incluir el archivo de conexión a la base de datos
include("conexion.php");

// Obtener el ID actual desde la URL
$cliente_id_actual = isset($_GET['id']) ? $_GET['id'] : null;

// Consulta SQL para obtener todos los IDs de clientes disponibles
$query = "SELECT id FROM clientes";
$resultado = $conexion->query($query);

// Obtener todos los IDs de clientes disponibles
$ids_clientes = [];
while ($fila = $resultado->fetch_assoc()) {
    $ids_clientes[] = $fila['id'];
}

// Encontrar el índice del ID actual en el array de IDs
$currentIndex = array_search($cliente_id_actual, $ids_clientes);

// Manejar la navegación
if ($currentIndex !== false && (isset($_POST['prev']) || isset($_POST['next']))) {
    if (isset($_POST['prev'])) {
        $currentIndex = ($currentIndex === 0) ? count($ids_clientes) - 1 : $currentIndex - 1;
    } elseif (isset($_POST['next'])) {
        $currentIndex = ($currentIndex === count($ids_clientes) - 1) ? 0 : $currentIndex + 1;
    }
    
    // Obtener el ID del cliente después de la navegación
    $nuevo_cliente_id = $ids_clientes[$currentIndex];

    // Redirigir a perfil_abonos.php con el nuevo ID
    header("Location: perfil_abonos.php?id=$nuevo_cliente_id");
    exit();
}

// Lógica para la selección de cliente si no se presionó < o >
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['cliente'])) {
    $cliente_id = $_POST['cliente'];
    header("Location: perfil_abonos.php?id=$cliente_id");
    exit();
}

// Cerrar la conexión
$conexion->close();
?>
