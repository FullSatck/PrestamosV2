<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
include("../../../../controllers/conexion.php");

// Inicializar variables
$idRetiro = $_GET['id']; // Obtener el ID del retiro de la URL

// Verificar si se ha enviado el formulario de editar retiro
if (isset($_POST['editar_retiro'])) {
    // Recoger los datos del formulario
    $idZona = $_POST['idZona'];
    $fecha = $_POST['fecha'];
    $valor = $_POST['valor'];
    $descripcion = $_POST['descripcion'];

    // Actualizar los datos del retiro en la base de datos
    $sql = "UPDATE retiros SET IDZona = '$idZona', Fecha = '$fecha', Valor = '$valor', Descripcion = '$descripcion' WHERE ID = $idRetiro";

    if ($conexion->query($sql) === TRUE) {
        // Retiro editado con éxito, redirigir a la lista de retiros
        header("location: retiros.php");
        exit();
    } else {
        $error = "Error al editar el retiro: " . $conexion->error;
    }
}

// Consulta SQL para obtener los datos del retiro
$sqlRetiro = "SELECT zonas.ID AS IDZona, zonas.Nombre AS NombreZona, retiros.Fecha, retiros.Valor, retiros.Descripcion FROM retiros INNER JOIN zonas ON retiros.IDZona = zonas.ID WHERE retiros.ID = $idRetiro";
$resultadoRetiro = $conexion->query($sqlRetiro);

if ($resultadoRetiro->num_rows === 1) {
    $row = $resultadoRetiro->fetch_assoc();
    $idZona = $row['IDZona'];
    $nombreZona = $row['NombreZona'];
    $fecha = $row['Fecha'];
    $valor = $row['Valor'];
    $descripcion = $row['Descripcion'];
} else {
    // No se encontró el retiro, mostrar un mensaje de error y salir
    echo "Retiro no encontrado.";
    exit();
}

// Consulta SQL para obtener la lista de zonas
$sqlZonas = "SELECT ID, Nombre FROM zonas";
$resultadoZonas = $conexion->query($sqlZonas);

if ($resultadoZonas === false) {
    die("Error en la consulta de zonas: " . $conexion->error);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Retiro</title>
    <link rel="stylesheet" href="/public/assets/css/editar_retiro.css">
</head>
<body>
    <h1>Editar Retiro</h1>
    <?php
    // Mostrar mensaje de error, si existe
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
    <form method="post">
        <label>Zona: </label>
        <select name="idZona">
            <?php
            // Generar las opciones del menú desplegable con las zonas
            while ($row = $resultadoZonas->fetch_assoc()) {
                $selected = ($row["ID"] == $idZona) ? "selected" : "";
                echo "<option value='" . $row["ID"] . "' $selected>" . $row["Nombre"] . "</option>";
            }
            ?>
        </select><br>
        <label>Fecha: </label>
        <input type="date" name="fecha" value="<?php echo $fecha; ?>"><br>
        <label>Valor: </label>
        <input type="number" step="0.01" name="valor" value="<?php echo $valor; ?>"><br>
        <label>Descripción: </label>
        <textarea name="descripcion"><?php echo $descripcion; ?></textarea><br>
        <input type="submit" name="editar_retiro" value="Guardar">
        <a href="/resources/views/admin/retiros/retiros.php">Volver</a>
    </form>
</body>
</html>
