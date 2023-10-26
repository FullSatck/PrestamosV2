<?php
// Incluye el archivo de conexión a la base de datos
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["registrar_usuario"])) {
    // Recoge los datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
    $zona = $_POST["zona"];
    $rol = $_POST["RolID"];

    // Validación de datos (puedes personalizar estas validaciones según tus necesidades)
    if (empty($nombre) || empty($apellido) || empty($email) || empty($contrasena)) {
        echo "Por favor, complete todos los campos.";
    } else {
        // Realiza la inserción en la base de datos
        $insertQuery = "INSERT INTO usuarios (Nombre, Apellido, Email, Password, Zona, RolID) 
                        VALUES ('$nombre', '$apellido', '$email', '$contrasena', '$zona', $rol)";
        
        if (mysqli_query($conexion, $insertQuery)) {
            echo "Usuario registrado con éxito.";
        } else {
            echo "Error al registrar el usuario: " . mysqli_error($conexion);
        }
    }
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>
