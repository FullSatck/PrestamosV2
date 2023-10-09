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

        // Prepara la consulta SQL para insertar en la tabla "usuarios"
        $sqlUsuarios = "INSERT INTO Usuarios (Nombre, Apellido, Email, Password, Zona, RolID) 
                        VALUES (?, ?, ?, ?, ?, ?)";

        $stmtUsuarios = $conexion->prepare($sqlUsuarios);

        if ($stmtUsuarios) {
            // Asigna los valores a los marcadores de posición en la consulta preparada
            $stmtUsuarios->bind_param("sssssi", $nombre, $apellido, $email, $contrasenaHasheada, $zona, $rol);

            // Ejecuta la consulta para insertar en la tabla "usuarios"
            if ($stmtUsuarios->execute()) {
                // Obtiene el ID del usuario recién insertado
                $nuevoUsuarioID = $stmtUsuarios->insert_id;

                // Inserta en la tabla correspondiente según el rol
                if ($rol == 1) {
                    // Si el rol es "admin", no se necesita insertar en las otras tablas
                    // Redirige al usuario a una página de éxito o muestra un mensaje
                    header("Location: ../resources/views/admin/usuarios/crudusuarios.php"); // Reemplaza 'registro_exitoso.php' con la página que desees mostrar después del registro exitoso
                    exit();
                } elseif ($rol == 2) {
                    // Si el rol es "supervisor", inserta en la tabla "usuario_supervisor"
                    $sqlUsuarioSupervisor = "INSERT INTO usuario_supervisor (SupervisorID, UsuarioID) VALUES (?, ?)";

                    $stmtUsuarioSupervisor = $conexion->prepare($sqlUsuarioSupervisor);

                    if ($stmtUsuarioSupervisor) {
                        // Asigna los valores a los marcadores de posición en la consulta preparada
                        $stmtUsuarioSupervisor->bind_param("ii", $nuevoUsuarioID, $nuevoUsuarioID);

                        // Ejecuta la consulta para insertar en la tabla "usuario_supervisor"
                        if ($stmtUsuarioSupervisor->execute()) {
                            // Redirige al usuario a una página de éxito o muestra un mensaje
                            header("Location: ../resources/views/admin/usuarios/crudusuarios.php"); // Reemplaza 'registro_exitoso.php' con la página que desees mostrar después del registro exitoso
                            exit();
                        } else {
                            echo "Error al registrar en la tabla usuario_supervisor: " . $stmtUsuarioSupervisor->error;
                        }

                        $stmtUsuarioSupervisor->close();
                    } else {
                        echo "Error de consulta preparada para usuario_supervisor: " . $conexion->error;
                    }
                } elseif ($rol == 3) {
                    // Si el rol es "cobrador", inserta en la tabla "usuario_cobrador"
                    $sqlUsuarioCobrador = "INSERT INTO usuario_cobrador (CobradorID, UsuarioID) VALUES (?, ?)";

                    $stmtUsuarioCobrador = $conexion->prepare($sqlUsuarioCobrador);

                    if ($stmtUsuarioCobrador) {
                        // Asigna los valores a los marcadores de posición en la consulta preparada
                        $stmtUsuarioCobrador->bind_param("ii", $nuevoUsuarioID, $nuevoUsuarioID);

                        // Ejecuta la consulta para insertar en la tabla "usuario_cobrador"
                        if ($stmtUsuarioCobrador->execute()) {
                            // Redirige al usuario a una página de éxito o muestra un mensaje
                            header("Location: ../resources/views/admin/usuarios/crudusuarios.php"); // Reemplaza 'registro_exitoso.php' con la página que desees mostrar después del registro exitoso
                            exit();
                        } else {
                            echo "Error al registrar en la tabla usuario_cobrador: " . $stmtUsuarioCobrador->error;
                        }

                        $stmtUsuarioCobrador->close();
                    } else {
                        echo "Error de consulta preparada para usuario_cobrador: " . $conexion->error;
                    }
                }
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
    // Redirecciona o muestra un mensaje de error si se accede directamente a este archivo sin enviar el formulario.
    echo "Acceso no autorizado.";
}
?>
