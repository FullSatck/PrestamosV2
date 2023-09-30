<?php
// Verifica si se han enviado datos por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $cobrador_asignado = $_POST["cobrador_asignado"];
    
    // Realiza la conexión a la base de datos (ajusta los detalles de conexión según tu configuración)
    $conexion = mysqli_connect("tu_servidor", "tu_usuario", "tu_contraseña", "tu_base_de_datos");
    
    // Verifica si la conexión fue exitosa
    if (!$conexion) {
        die("Error en la conexión: " . mysqli_connect_error());
    }
    
    // Escapa los datos para evitar problemas de seguridad
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $descripcion = mysqli_real_escape_string($conexion, $descripcion);
    
    // Query SQL para insertar los datos en la tabla "zonas"
    $sql = "INSERT INTO zonas (Nombre, Descripcion, CobradorAsignado) VALUES ('$nombre', '$descripcion', $cobrador_asignado)";
    
    if (mysqli_query($conexion, $sql)) {
        echo "Registro exitoso. La zona se ha agregado a la base de datos.";
    } else {
        echo "Error en el registro: " . mysqli_error($conexion);
    }
    
    // Cierra la conexión a la base de datos
    mysqli_close($conexion);
} else {
    // Si no se recibieron datos por POST, muestra un mensaje de error
    echo "Acceso no permitido.";
}
?>
