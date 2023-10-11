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

// Consulta SQL para obtener la lista de usuarios con RolID 2 (supervisores)
$sqlSupervisores = "SELECT ID, Nombre FROM usuarios WHERE RolID = 2";
$resultadoSupervisores = $conexion->query($sqlSupervisores);

if ($resultadoSupervisores === false) {
    die("Error en la consulta de supervisores: " . $conexion->error);
}

// Variable para el mensaje de éxito
$exito = "";

// Verificar si se ha enviado el formulario de agregar retiro
if (isset($_POST['agregar_retiro'])) {
    // Recoger los datos del formulario
    $idUsuario = $_POST['idUsuario'];
    $valor = $_POST['valor'];
    $monto = $_POST['monto'];

    // Validar que el usuario seleccionado existe en la base de datos y es un supervisor
    $sqlValidarUsuario = "SELECT ID FROM usuarios WHERE ID = $idUsuario AND RolID = 2";
    $resultadoValidacion = $conexion->query($sqlValidarUsuario);

    if ($resultadoValidacion->num_rows === 0) {
        // El usuario seleccionado no es válido o no es un supervisor, mostrar un mensaje de error
        $error = "El usuario seleccionado no es un supervisor válido.";
    } else {
        // El usuario es válido, proceder a insertar el retiro
        $sql = "INSERT INTO retiros (IDUsuario, Valor, Monto) VALUES ('$idUsuario', '$valor', '$monto')";

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
        <label>Supervisor: </label>
        <select name="idUsuario">
            <?php
            // Generar las opciones del menú desplegable con los supervisores
            while ($row = $resultadoSupervisores->fetch_assoc()) {
                echo "<option value='" . $row["ID"] . "'>" . $row["Nombre"] . "</option>";
            }
            ?>
        </select><br>

        <label>Valor: </label>
        <input type="number" step="0.01" name="valor"><br>

        <label>Monto: </label>
        <input type="number" step="0.01" name="monto"><br>

        <input type="submit" name="agregar_retiro" value="Agregar Retiro">
        <a href="retiros.php"> Volver</a>
    </form>
    <br>
</body>
</html>
