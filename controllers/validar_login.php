<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['contrasena'];

    // Conexión a la base de datos
    include("conexion.php");

    // Consulta para verificar el correo electrónico, obtener la contraseña hash y el ID del rol
    $consultaUsuario = "SELECT ID, Password, RolID FROM usuarios WHERE Email = ?";
    $stmtUsuario = $conexion->prepare($consultaUsuario);

    if ($stmtUsuario) {
        $stmtUsuario->bind_param("s", $email);
        $stmtUsuario->execute();
        $stmtUsuario->store_result();

        if ($stmtUsuario->num_rows == 1) {
            $stmtUsuario->bind_result($userID, $hashedPassword, $userRoleID);
            $stmtUsuario->fetch();

            // Verificar la contraseña ingresada con la contraseña almacenada en la base de datos
            if (password_verify($password, $hashedPassword)) {
                // Inicio de sesión exitoso

                session_start();
                $_SESSION['user_id'] = $userID;
                $_SESSION['user_role_id'] = $userRoleID; // Almacena el ID del rol en la sesión

                // Redireccionar según el ID del rol (ajusta las URL según tu estructura de carpetas)
                if ($userRoleID == 1) {
                    // Redirige al panel de "admin"
                    header("Location: ../resources/views/admin_panel.php");
                } elseif ($userRoleID == 2) {
                    // Redirige al panel de "supervisor"
                    header("Location: ../resources/views/supervisor_panel.php");
                } elseif ($userRoleID == 3) {
                    // Redirige al panel de "cobrador"
                    header("Location: ../resources/views/cobrador_panel.php");
                } else {
                    echo "Rol desconocido.";
                }
                exit();
            } else {
                echo "La contraseña es incorrecta.";
            }
        } else {
            echo "El correo electrónico no está registrado.";
        }

        $stmtUsuario->close();
    } else {
        echo "Error de consulta preparada: " . $conexion->error;
    }

    $conexion->close();
} else {
    echo "Acceso no autorizado.";
}
?>
