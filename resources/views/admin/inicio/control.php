<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control del Sistema</title>
    <link rel="stylesheet" href="control.css">
</head>
<body>
    <?php
    require 'funciones.php';
    $userID = 1;  // Cambia esto por el ID del usuario actual.
    if (isset($_POST['cerrar'])) {
        cerrarSistema($userID);
    }
    if (isset($_POST['abrir'])) {
        reactivarSistema($userID);
    }
    ?>
    <form action="control.php" method="post">
        <button type="submit" name="cerrar">Cerrar Sistema</button>
        <button type="submit" name="abrir">Reactivar Sistema</button>
    </form>
    <p>Estado del sistema: <?php echo sistemaActivo() ? 'Activo' : 'Inactivo'; ?></p>
</body>
</html>
