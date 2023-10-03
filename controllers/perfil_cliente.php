<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// Verificar si se ha pasado un ID válido como parámetro GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirigir a una página de error o a la lista de clientes
    header("location: lista_clientes.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
include("conexion.php");

// Obtener el ID del cliente desde el parámetro GET
$id_cliente = $_GET['id'];

// Consulta SQL para obtener los detalles del cliente
$sql = "SELECT * FROM clientes WHERE ID = $id_cliente";
$resultado = $conexion->query($sql);

if ($resultado->num_rows === 1) {
    // Mostrar los detalles del cliente aquí
    $fila = $resultado->fetch_assoc();
    
    // Obtener la ruta de la imagen del cliente desde la base de datos
    $imagen_cliente = $fila["ImagenCliente"];
    
    // Si no hay imagen cargada, usar una imagen de reemplazo
    if (empty($imagen_cliente)) {
        $imagen_cliente = "../public/assets/img/perfil.png"; // Reemplaza con tu imagen por defecto
    }
} else {
    // Cliente no encontrado en la base de datos, redirigir a una página de error o a la lista de clientes
    header("location: lista_clientes.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/perfil_cliente.css"> <!-- Asegúrate de incluir tu hoja de estilos CSS -->
    <title>Perfil del Cliente</title>
</head>
<body>
    <h1>Perfil del Cliente</h1>
    <div class="profile-container">
        <div class="profile-image">
            <!-- Mostrar la foto del cliente -->
            <img src="<?= $imagen_cliente ?>" alt="Foto del Cliente">
        </div>
        <div class="profile-details">
            <!-- Mostrar los datos del cliente -->
            <h1><?= $fila["Nombre"] ?></h1>
            <p><?= $fila["Apellido"] ?></p>
            <p>Domicilio: <?= $fila["Domicilio"] ?></p>
            <p>Teléfono: <?= $fila["Telefono"] ?></p>
            <p>Historial Crediticio: <?= $fila["HistorialCrediticio"] ?></p>
            <p>Referencias Personales: <?= $fila["ReferenciasPersonales"] ?></p>
            <p>Moneda Preferida: <?= $fila["MonedaPreferida"] ?></p>
            <p>Zona Asignada: <?= $fila["ZonaAsignada"] ?></p>
        </div>
    </div>
</body>
</html>
