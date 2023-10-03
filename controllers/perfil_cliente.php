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

// Consulta SQL para obtener los préstamos del cliente
$sql_prestamos = "SELECT * FROM prestamos WHERE IDCliente = $id_cliente";
$resultado_prestamos = $conexion->query($sql_prestamos);
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
    
    <!-- Agregar una sección para mostrar los préstamos del cliente -->
    <div class="profile-loans">
        <h2>Préstamos del Cliente</h2>
        <table>
            <thead>
                <tr>
                    <th>ID del Préstamo</th>
                    <th>Monto</th>
                    <th>Tasa de Interés</th>
                    <th>Plazo</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila_prestamo = $resultado_prestamos->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $fila_prestamo["ID"] ?></td>
                        <td><?= $fila_prestamo["Monto"] ?></td>
                        <td><?= $fila_prestamo["TasaInteres"] ?></td>
                        <td><?= $fila_prestamo["Plazo"] ?></td>
                        <td><?= $fila_prestamo["FechaInicio"] ?></td>
                        <td><?= $fila_prestamo["FechaVencimiento"] ?></td>
                        <td><?= $fila_prestamo["Estado"] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Agregar un enlace para gestionar los préstamos -->
    <div class="manage-loans">
        <a href="gestion_prestamos.php?id_cliente=<?= $id_cliente ?>">Gestionar Préstamos</a>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const profileImage = document.querySelector('.profile-image img');
    
    // Agrega un controlador de eventos para hacer clic en la imagen
    profileImage.addEventListener('click', function () {
        profileImage.classList.toggle('zoomed'); // Alterna la clase 'zoomed'
    });
});
</script>

</body>
</html>
