<?php
// Incluir el archivo de conexión a la base de datos
include("conexion.php");

// Obtener el ID actual desde la URL
$cliente_id_actual = isset($_GET['id']) ? $_GET['id'] : null;
 

// Lógica para la selección de cliente si no se presionó < o >
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['cliente'])) {
    $cliente_id = $_POST['cliente'];
    header("Location: perfil_abonos.php?id=$cliente_id");
    exit();
}
 
?>
