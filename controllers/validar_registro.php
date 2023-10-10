<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $zona = $_POST['zona'];
    $rol = $_POST['rol']; // Esto debe ser un valor de 'admin', 'supervisor' o 'cobrador'

    if (empty($nombre) || empty($apellido) || empty($email) || empty($contrasena) || empty($zona) || empty($rol)) {
        echo "Todos los campos son obligatorios. Por favor, complete el formulario.";
    } else {
        $contrasenaHasheada = password_hash($contrasena, PASSWORD_DEFAULT);

        include("conexion.php");

        $sqlUsuarios = "INSERT INTO usuarios (Nombre, Apellido, Email, Password, Zona, Rol) 
                        VALUES (?, ?, ?, ?, ?, ?)";

        $stmtUsuarios = $conexion->prepare($sqlUsuarios);

        if ($stmtUsuarios) {
            $stmtUsuarios->bind_param("ssssss", $nombre, $apellido, $email, $contrasenaHasheada, $zona, $rol);

            if ($stmtUsuarios->execute()) {
                header("Location: ../resources/views/admin/usuarios/crudusuarios.php");
                exit();
            } else {
                echo "Error al registrar el usuario: " . $stmtUsuarios->error;
            }

            $stmtUsuarios->close();
        } else {
            echo "Error de consulta preparada para usuarios: " . $conexion->error;
        }

        $conexion->close();
    }
} else {
    echo "Acceso no autorizado.";
}
?>
