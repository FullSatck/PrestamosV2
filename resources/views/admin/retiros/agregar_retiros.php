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

// Consulta SQL para obtener la lista de zonas
$sqlZonas = "SELECT ID, Nombre FROM zonas";
$resultadoZonas = $conexion->query($sqlZonas);

if ($resultadoZonas === false) {
    die("Error en la consulta de zonas: " . $conexion->error);
}

// Variable para el mensaje de éxito
$exito = "";

// Verificar si se ha enviado el formulario de agregar retiro
if (isset($_POST['agregar_retiro'])) {
    // Recoger los datos del formulario
    $idZona = $_POST['idZona'];
    $fecha = $_POST['fecha'];
    $valor = $_POST['valor'];
    $descripcion = $_POST['descripcion'];

    // Validar que la zona seleccionada existe en la base de datos
    $sqlValidarZona = "SELECT ID FROM zonas WHERE ID = $idZona";
    $resultadoValidacion = $conexion->query($sqlValidarZona);

    if ($resultadoValidacion->num_rows === 0) {
        // La zona seleccionada no existe, mostrar un mensaje de error
        $error = "La zona seleccionada no es válida.";
    } else {
        // La zona es válida, proceder a insertar el retiro
        $sql = "INSERT INTO retiros (IDZona, Fecha, Valor, Descripcion) VALUES ('$idZona', '$fecha', '$valor', '$descripcion')";

        if ($conexion->query($sql) === TRUE) {
            // Retiro creado con éxito
            $exito = "Retiro creado con éxito";
            
            // Redireccionar a la lista de retiros después de 2 segundos
            header("refresh:2; url=retiros.php");
        } else {
            $error = "Error al agregar el retiro: " . $conexion->error;
        }
    }
}

?> 

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Retiro</title>
    <link rel="stylesheet" href="/public/assets/css/agregar_retiro.css">
</head>
<body>
    <h1>Agregar Retiro</h1>
    <?php
    // Mostrar mensaje de éxito o error
    if (isset($exito)) {
        echo "<p style='color: green;'>$exito</p>";
    }
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
    <!-- Formulario para agregar un retiro -->
    <form method="post">
        <label>Zona: </label>
        <select name="idZona">
            <?php
            // Generar las opciones del menú desplegable con las zonas
            while ($row = $resultadoZonas->fetch_assoc()) {
                echo "<option value='" . $row["ID"] . "'>" . $row["Nombre"] . "</option>";
            }
            ?>
        </select><br>
        <label>Fecha: </label>
        <input type="date" name="fecha"><br>
        <label>Valor: </label>
        <input type="number" step="0.01" name="valor"><br>
        <label>Descripción: </label>
        <textarea name="descripcion"></textarea><br>
        <input type="submit" name="agregar_retiro" value="Agregar Retiro">
        <a href="retiros.php">Volver</a>
    </form>
    <br>
</body>
</html>
