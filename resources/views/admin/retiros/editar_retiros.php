<?php
session_start();

// Verifica la autenticación del usuario
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../../../index.php");
    exit();
}

include "../../../../controllers/conexion.php";

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

$fecha = $monto = $descripcion = "";
$fecha_err = $monto_err = $descripcion_err = "";
$monto_original = 0;

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $retiro_id = $_GET["id"];

    $sql = "SELECT Fecha, Monto, Descripcion FROM Retiros WHERE ID = ?";
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("i", $retiro_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $fecha = $row["Fecha"];
                $monto = $row["Monto"];
                $descripcion = $row["Descripcion"];
                $monto_original = $monto; // Guardar el valor original del monto del retiro
            } else {
                header("location: algun_lugar.php");
                exit();
            }
        } else {
            echo "Error al ejecutar la consulta.";
        }
        $stmt->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesamiento de los datos del formulario...
    $retiro_id = $_POST['retiro_id'];
    $fecha = $_POST['fecha'];
    $monto = $_POST['monto'];
    $descripcion = $_POST['descripcion'];

    // Validación de los datos del formulario...

    if (empty($fecha_err) && empty($monto_err) && empty($descripcion_err)) {
        // Obtener el monto original del retiro
        $sql_monto_original = "SELECT Monto FROM Retiros WHERE ID = ?";
        if ($stmt_monto_original = $conexion->prepare($sql_monto_original)) {
            $stmt_monto_original->bind_param("i", $retiro_id);
            $stmt_monto_original->execute();
            $stmt_monto_original->store_result();
            if ($stmt_monto_original->num_rows == 1) {
                $stmt_monto_original->bind_result($monto_original);
                $stmt_monto_original->fetch();
            }
            $stmt_monto_original->close();
        }

        // Actualizar el retiro en la base de datos
        $sql_actualizar_retiro = "UPDATE Retiros SET Fecha = ?, Monto = ?, Descripcion = ? WHERE ID = ?";
        if ($stmt_actualizar_retiro = $conexion->prepare($sql_actualizar_retiro)) {
            $stmt_actualizar_retiro->bind_param("sssi", $fecha, $monto, $descripcion, $retiro_id);
            if ($stmt_actualizar_retiro->execute()) {
                // Calcular la diferencia entre el monto original y el monto editado
                $diferencia_monto = $monto_original - $monto;

                // Actualizar el saldo neto con la diferencia
                $sql_update_saldo = "UPDATE saldo_admin SET Monto_Neto = Monto_Neto + ?";
                if ($stmt_update_saldo = $conexion->prepare($sql_update_saldo)) {
                    $stmt_update_saldo->bind_param("d", $diferencia_monto);
                    $stmt_update_saldo->execute();
                    $stmt_update_saldo->close();
                }

                // Redirección a la lista de retiros después de actualizar
                header("location: retiros.php?mensaje=Edición exitosa");
                exit();
            } else {
                echo "Error al actualizar el retiro.";
            }
            $stmt_actualizar_retiro->close();
        }
    }

    $conexion->close();
}
date_default_timezone_set('America/Bogota');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Editar Retiro</title>
     <link rel="stylesheet" href="/public/assets/css/editar_retiro.css">
</head>

<body>
    <header>
        
    </header>

    <main>
        <h1>Editar Retiro</h1>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="hidden" name="retiro_id" value="<?php echo $retiro_id; ?>">
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="datetime-local" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
                <span class="help-block"><?php echo $fecha_err; ?></span>
            </div>
            <div class="form-group">
                <label for="monto">Monto:</label>
                <input type="text" name="monto" id="monto" value="<?php echo $monto; ?>">
                <span class="help-block"><?php echo $monto_err; ?></span>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion"><?php echo $descripcion; ?></textarea>
                <span class="help-block"><?php echo $descripcion_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Guardar Cambios">
                <a href="retiros.php">Cancelar</a>
            </div>
        </form>
    </main>

    <footer>
        <!-- Agrega tu pie de página -->
    </footer>
</body>

</html>
