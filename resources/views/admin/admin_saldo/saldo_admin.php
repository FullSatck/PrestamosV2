<!DOCTYPE html>
<html>

<head>
    <title>Saldo Inicial</title>
    <link rel="stylesheet" href="/public/assets/css/saldo_admin.css">
</head>

<body>
<div class="container">
        <h2>Asignar Saldo Inicial al Administrador</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="monto">Monto:</label>
                <input type="number" step="0.01" id="monto" name="monto" required>
            </div>
            <button type="submit" name="guardar_saldo">Guardar</button>
        </form>
    </div>


    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar_saldo'])) {
        // Obtén el monto del formulario
        $monto = isset($_POST['monto']) ? floatval($_POST['monto']) : 0; // Asegúrate de tener un valor válido

        // Realiza la validación del monto si es necesario

        // Incluye el archivo de conexión a la base de datos
        include("../../../../controllers/conexion.php");

        // Supongamos que el ID de administrador es 1 (reemplaza con el valor correcto)
        $idAdmin = 1;

        // Inserta el saldo inicial en la tabla saldo_admin en ambas columnas
        $sql = "INSERT INTO saldo_admin (IDUsuario, Monto, Monto_Neto) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("idd", $idAdmin, $monto, $monto);

            if ($stmt->execute()) {
                echo "Saldo inicial guardado con éxito.";
            } else {
                echo "Error al guardar el saldo inicial: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error de consulta preparada: " . $conexion->error;
        }

        $conexion->close();
    }
    ?>
</body>

</html>