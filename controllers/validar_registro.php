<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $zona = $_POST['zona'];
    $rol = $_POST['rol'];

    // Validación básica (campos no vacíos)
    if (empty($nombre) || empty($apellido) || empty($email) || empty($contrasena) || empty($zona) || empty($rol)) {
        echo "Todos los campos son obligatorios. Por favor, complete el formulario.";
    } else {
        // Hashea la contraseña utilizando password_hash
        $contrasenaHasheada = password_hash($contrasena, PASSWORD_DEFAULT);

        // Incluye el archivo de conexión a la base de datos
        include("conexion.php");

        // Prepara la consulta SQL
        $sql = "INSERT INTO Usuarios (Nombre, Apellido, Email, Password, Zona, RolID) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);

        if ($stmt) {
            // Asigna los valores a los marcadores de posición en la consulta preparada
            $stmt->bind_param("sssssi", $nombre, $apellido, $email, $contrasenaHasheada, $zona, $rol);

            // Ejecuta la consulta
            if ($stmt->execute()) {
                // Redirige al usuario a una página de éxito o muestra un mensaje
                header("Location: ../resources/views/admin/usuarios/crudusuarios.php"); // Reemplaza 'registro_exitoso.php' con la página que desees mostrar después del registro exitoso
                exit();
            } else {
                echo "Error al registrar el usuario: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error de consulta preparada: " . $conexion->error;
        }

        $conexion->close();
    }
} else {
    // Redirecciona o muestra un mensaje de error si se accede directamente a este archivo sin enviar el formulario.
    echo "Acceso no autorizado.";
}
?>
