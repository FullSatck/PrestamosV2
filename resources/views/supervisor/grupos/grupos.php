
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

// Realizar la consulta para obtener los grupos de la base de datos
$query = "SELECT * FROM Roles";
$result = mysqli_query($conexion, $query);

if (!$result) {
    // Manejar errores en la consulta si es necesario
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/grupos.css">
    <title>Roles</title>
    <!-- Agrega aquí tus estilos CSS si es necesario -->
</head>

<body>
    <h1>Roles</h1>
    <button><a href="/resources/views/admin/inicio/inicio.php">Volver al Inicio</a></button> 
    <button><a href="/resources/views/admin/grupos/agregar_grupos.php">Añadir Rol</a></button><br><br><br>
 
    <!-- Mostrar los grupos en una lista -->
    <ul>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        // Define las URLs correspondientes a cada rol
        $urls = [
            "admin" => "admin.php",
            "supervisor" => "supervisor.php",
            "cobrador" => "cobrador.php"
        ];
        
        // Verifica si el nombre del rol existe en las URLs definidas
        if (array_key_exists($row['Nombre'], $urls)) {
            $url = $urls[$row['Nombre']];
            echo "<li><a href='$url'>" . $row['Nombre'] . "</a></li>";
        } else {
            echo "<li>" . $row['Nombre'] . "</li>";
        }
    }
    ?>
</ul>


</body>

</html>
