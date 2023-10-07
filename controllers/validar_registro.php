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
                // Si el rol es "cobrador", inserta también en la tabla "zona_cobrador"
                if ($rol == 3) {
                    // Obtiene el ID del usuario recién insertado
                    $nuevoUsuarioID = $stmtUsuarios->insert_id;

                    // Prepara la consulta SQL para insertar en la tabla "zona_cobrador"
                    $sqlZonaCobrador = "INSERT INTO zona_cobrador (ZonaID, CobradorID) VALUES (?, ?)";

                    $stmtZonaCobrador = $conexion->prepare($sqlZonaCobrador);

                    if ($stmtZonaCobrador) {
                        // Asigna los valores a los marcadores de posición en la consulta preparada
                        $stmtZonaCobrador->bind_param("ii", $zona, $nuevoUsuarioID);

                        // Ejecuta la consulta para insertar en la tabla "zona_cobrador"
                        if ($stmtZonaCobrador->execute()) {
                            // Redirige al usuario a una página de éxito o muestra un mensaje
                            header("Location: ../resources/views/admin/usuarios/crudusuarios.php"); // Reemplaza 'registro_exitoso.php' con la página que desees mostrar después del registro exitoso
                            exit();
                        } else {
                            echo "Error al registrar en la tabla zona_cobrador: " . $stmtZonaCobrador->error;
                        }

                        $stmtZonaCobrador->close();
                    } else {
                        echo "Error de consulta preparada para zona_cobrador: " . $conexion->error;
                    }
                } else {
                    // Si el rol no es "cobrador", solo redirige al usuario a la página de éxito
                    header("Location: ../resources/views/admin/usuarios/crudusuarios.php"); // Reemplaza 'registro_exitoso.php' con la página que desees mostrar después del registro exitoso
                    exit();
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
