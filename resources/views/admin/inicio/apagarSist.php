<?php
session_start();
include("../../../../controllers/conexion.php");

// Inicializa la variable
$estadoActual = 'inactivo'; // Valor por defecto

// Consulta para obtener el estado actual del sistema
$sql = "SELECT Estado FROM sistema_estado ORDER BY ID DESC LIMIT 1";
$resultado = $conexion->query($sql);

if ($resultado && $fila = $resultado->fetch_assoc()) {
    $estadoActual = $fila['Estado'];
}

// Cierra la conexión
$conexion->close();

// Mensaje de confirmación
$mensajeConfirmacion = '';
if (isset($_SESSION['cambio_estado_mensaje'])) {
    $mensajeConfirmacion = $_SESSION['cambio_estado_mensaje'];
    unset($_SESSION['cambio_estado_mensaje']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cambiar Estado del Sistema</title>
    <link rel="stylesheet" href="/public/assets/css/Estadosistema.css">
</head>

<body>
    <div class="container">
        <h1>Cambiar Estado del Sistema</h1>

        <?php if ($mensajeConfirmacion) : ?>
            <strong><div id="mensajeConfirmacion" class="mensaje-confirmacion">
                <?php echo $mensajeConfirmacion; ?>
            </div></strong>
        <?php endif; ?>

        <strong>
            <p class="estado-actual">Estado actual del sistema: <?php echo $estadoActual === 'activo' ? 'Encendido' : 'Apagado'; ?></p>
        </strong>

        <form action="cambiar_estado.php" method="post" class="form-estado">
            <div class="radio-group">
                <label>
                    <input type="radio" name="estado" value="activo" <?php echo $estadoActual === 'activo' ? 'checked' : ''; ?>>
                    Encender Sistema
                </label>
                <label>
                    <input type="radio" name="estado" value="inactivo" <?php echo $estadoActual === 'inactivo' ? 'checked' : ''; ?>>
                    Apagar Sistema
                </label>
            </div>
            <button type="submit">Cambiar Estado</button>
        </form>
    </div>
    <script>
        // Oculta el mensaje después de 5 segundos (5000 milisegundos)
        setTimeout(function() {
            var mensaje = document.getElementById('mensajeConfirmacion');
            if (mensaje) {
                mensaje.style.display = 'none';
            }
        }, 2000);
    </script>
</body>

</html>