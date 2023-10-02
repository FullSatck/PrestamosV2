<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
include("../../../../controllers/conexion.php"); // Asegúrate de que este archivo contiene tu conexión a la base de datos

// Variables para almacenar los datos del nuevo grupo
$nombre_grupo = "";

// Variable para almacenar mensajes de éxito o error
$mensaje = "";

// Manejar el envío del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_grupo = $_POST["nombre_grupo"];

    // Validar que el nombre del grupo no esté vacío
    if (empty($nombre_grupo)) {
        $mensaje = "Por favor, ingresa el nombre del grupo.";
    } else {
        // Realizar la inserción del nuevo grupo en la base de datos
        $query = "INSERT INTO Roles (Nombre) VALUES (?)";
        $stmt = mysqli_prepare($conexion, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $nombre_grupo);
            if (mysqli_stmt_execute($stmt)) {
                $mensaje = "Grupo agregado con éxito.";
                $nombre_grupo = ""; // Limpiar el campo de nombre después de la inserción
            } else {
                $mensaje = "Error al agregar el grupo: " . mysqli_error($conexion);
            }
            mysqli_stmt_close($stmt);
        } else {
            $mensaje = "Error de consulta preparada: " . mysqli_error($conexion);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/agregar_grupos.css">
    <title>Agregar Grupo</title>
    <!-- Agrega aquí tus estilos CSS si es necesario -->
</head>

<body>
    <h1>Agregar Roles</h1>
    <button><a href="/resources/views/admin/grupos/grupos.php">Volver</a></button>

    <!-- Mostrar mensaje de éxito o error -->
    <?php if (!empty($mensaje)) : ?>
        <p><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <!-- Formulario para agregar un nuevo grupo -->
    <form method="post">
        <label for="nombre_grupo">Nombre del Rol:</label>
        <input type="text" id="nombre_grupo" name="nombre_grupo" value="<?php echo $nombre_grupo; ?>" required>
        <button type="submit">Agregar Rol</button>
    </form>
</body>

</html>
