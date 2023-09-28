<?php
// Incluye el archivo de conexión a la base de datos
include("conexion.php");

// Recupera los datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Almacena la contraseña de manera segura
$zona = $_POST['zona'];
$monedaPreferida = $_POST['moneda'];
$rolID = $_POST['rol'];

// Consulta SQL para insertar el nuevo usuario en la tabla "Usuarios"
$sql = "INSERT INTO Usuarios (Nombre, Apellido, Email, Password, Zona, MonedaPreferida, RolID) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conexion, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssssssi", $nombre, $apellido, $email, $contrasena, $zona, $monedaPreferida, $rolID);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Usuario registrado exitosamente.";
    } else {
        echo "Error al registrar el usuario: " . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Error en la consulta preparada: " . mysqli_error($conexion);
}

// Cierra la conexión a la base de datos cuando hayas terminado
mysqli_close($conexion);
?>
